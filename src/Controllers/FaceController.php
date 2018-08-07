<?php
namespace BurnerMap\Controllers;

use DB;
use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use BurnerMap\Models\Burners;
use BurnerMap\Models\BurnerFriends;
use BurnerMap\Models\AllPastUsers;
use BurnerMap\Models\BurnerPastFriendUsers;
use BurnerMap\Models\BurnerCamps;
use BurnerMap\Models\BurnerVillages;
use BurnerMap\Models\PageLoads;

use BurnerMap\Controllers\BurnerInfo;
use BurnerMap\Controllers\IncUtils;

class FaceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Facebook Connection Controller
    |--------------------------------------------------------------------------
    |
    | Since most pages require an established Facebook connection, this controller is core.
    | The Facebook connection itself uses Laravel's Socialite plugin: https://github.com/laravel/socialite
    |
    */
    
    // User information returned from Facebook via Socialite plugin
    protected $usr       = null;
    
    // The user's core `Burners` database table row with their year's camping info (largely contents of Edit form)
    protected $myBurn    = null;
    
    // BurnerInfo: A class which can load and contain many more details about this user's friend lists, etc.
    protected $myInfo    = null;
    
    // System totals
    protected $tots      = [];
    
    // BurnerVars: Some general system variables like list of street clock addresses, etc.
    protected $vars      = [];
    
    // Current page [type] being loaded
    protected $currPage  = 'welcome';
    protected $currUrl   = '';
    protected $archYear  = '';
    protected $cachExpir = 0;
    
    // Collection of HTML and JS content destined for this page load
    protected $mainout   = '';
    protected $java      = '';
    protected $ajax      = '';
    
    // Scopes assigned for Facebook API connection
    protected $fbFields = ['id', 'name', 'link', 'picture', 'friends'];
    protected $fbScopes = ['public_profile', 'user_friends'];
    
    /**
     * Create a new Facebook Controller instance. Initializes global utility functions.
     *
     * @return void
     */
    function __construct()
    {
        $GLOBALS["util"] = new IncUtils;
        $this->cachExpir = mktime(0, 0, 0, date("n"), date("j")-1, date("Y"));
    }
    
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request)
    {
        try {
            return Socialite::driver('facebook')
                ->scopes($this->fbScopes)
                //->stateless()     // (tried this fix to no avail)
                ->redirect();
        } catch ( \InvalidArgumentException $e ) {
            return redirect('/welcome');
        }
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('facebook')
            ->user();
        session()->put('burntok', $user->token);
        return redirect('/map');
    }

    /**
     * Logout by deleting the session token used to quickly reestablish current Facebook connection.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        session()->forget('burntok');
        //Auth::logout();
        return redirect('/welcome');
    }
    
    /**
     * Load key user variables and load fresh friends list.
     *
     * @return boolean
     */
    public function loadUserInfo()
    {
        eval("\$this->myBurn = BurnerMap\\Models\\Burners" . $this->archYear . "::where('user', " . $this->usr->id . ")
            ->first();");
        if (!$this->myBurn) {
            eval("\$this->myBurn = new BurnerMap\\Models\\Burners" . $this->archYear . ";");
            $this->myBurn->user = $this->usr->id;
            $this->myBurn->name = $this->usr->name;
            $this->myBurn->save();
        }
        $allChk = AllPastUsers::where('user', $this->usr->id)
            ->first();
        if (!$allChk) {
            $allChk = new AllPastUsers;
            $allChk->user = $this->usr->id;
            $allChk->name = $this->usr->name;
            $allChk->save();
        }
        $this->myInfo = new BurnerInfo;
        $this->myInfo->userMod = $this->usr->id%10;
        
        $frnds = BurnerFriends::where('user', $this->usr->id)
            ->first();
        if (!$frnds) { 
            $frnds = new BurnerFriends;
            $frnds->user    = $this->usr->id;
            $frnds->friends = ',';
            $frnds->save();
        }
        if ($frnds->friends == ',' || !session()->has('frndChk')) {
            $frnds->friends = ',';
            if (isset($this->usr->user) && isset($this->usr->user["friends"]) && isset($this->usr->user["friends"]["data"])
                && sizeof($this->usr->user["friends"]["data"]) > 0) {
                foreach ($this->usr->user["friends"]["data"] as $i => $f) {
                    $this->myInfo->myFriends[] = $f["id"];
                }
                $frnds->friends .= implode(',', $this->myInfo->myFriends) . ',';
            }
            if (isset($this->usr->user) && isset($this->usr->user["friends"]) 
                && isset($this->usr->user["friends"]["paging"]) 
                && isset($this->usr->user["friends"]["paging"]["next"])) {
                $frnds->friends .= $this->loadFriendsLists($this->usr->user["friends"]["paging"]["next"]);
            }
            $frnds->save();
            session()->put('frndChk', date("Y-m-d"));
        }
        return true;
    }
    
    /**
     * Load pages of friend lists from Facebook, returns comma separated IDs.
     *
     * @param  string $nextPage
     * @return string
     */
    public function loadFriendsLists($nextPage = '')
    {
        $ret = '';
        $page = json_decode(file_get_contents($nextPage), true);
        if (is_array($page) && isset($page["data"]) && sizeof($page["data"]) > 0) {
            foreach ($page["data"] as $i => $f) {
                if (!in_array($f["id"], $this->myInfo->myFriends)) {
                    $this->myInfo->myFriends[] = $f["id"];
                    $ret .= $f["id"] . ',';
                }
            }
            if (isset($page["paging"]) && isset($page["paging"]["next"]) && trim($page["paging"]["next"]) != '') {
                $ret .= $this->loadFriendsLists($page["paging"]["next"]);
            }
        }
        return $ret;
    }
    
    /**
     * Primary function call to initiate and check each page load, and reestablish Facebook connection.
     *
     * @param  Illuminate\Http\Request $request
     * @param  string $currPage The page (type) currently being loaded
     * @return boolean
     */
    public function loadPage(Request $request, $currPage = 'welcome')
    {
        $this->currPage = $currPage;
        // Attempt reestablishing Facebook connection if session token exists
        if (session()->has('burntok')) {
            $tok = session()->get('burntok');
            $this->usr = Socialite::driver('facebook')
                ->fields($this->fbFields)
                ->scopes($this->fbScopes)
                ->userFromToken($tok);
        }
        if ($request->has('arch') && trim($request->get('arch')) != date("Y")) {
            $this->archYear = trim($request->get('arch'));
        } elseif ($request->has('year')) {
            $this->archYear = trim($request->get('year'));
        }
        if ($this->currPage == 'welcome') {
            if ($this->usr && isset($this->usr->id)) {
                return $GLOBALS["util"]->jsRedirect('/map');
            }
        } elseif (!in_array($this->currPage, ['privacy', 'json'])) {
            if (!$this->usr || !isset($this->usr->id) || intVal($this->usr->id) <= 0 || !session()->has('burntok')) {
                return $GLOBALS["util"]->jsRedirect('/welcome');
            }
            $this->loadUserInfo();
            if ($this->currPage == 'admin' && !$this->isAdmin()) {
                return $GLOBALS["util"]->jsRedirect('/map');
            }
        }
        $this->tots["totUsers"] = AllPastUsers::get()->count();
        $this->tots["totCurrUsers"] = Burners::get()->count();
        return true;
    }
    
    
    
    /**
     * Determine and return page header to print at the top of this page.
     *
     * @return string
     */
    public function loadHeader()
    {
        if ($this->currPage == 'admin') {
            return view('vendor.burnermap.admin.inc-header-admin', [
                "usr"    => $this->usr,
                "myBurn" => $this->myBurn
                ])->render();
        } elseif (in_array($this->currPage, ['welcome', 'privacy'])) {
            return view('vendor.burnermap.inc-header-welcome', [
                "currPage" => $this->currPage
                ])->render();
        } elseif ($this->currPage != 'welcome') {
            return view('vendor.burnermap.inc-header', [
                "usr"      => $this->usr,
                "myBurn"   => $this->myBurn,
                "currPage" => $this->currPage
                ])->render();
        }
        return '';
    }
    
    /**
     * Pass the previously compiled page output into the master view, and give the user their page.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function printPage(Request $request)
    {
        $uID = (($this->usr && isset($this->usr->id) && intVal($this->usr->id) > 0) ? $this->usr->id : 0);
        $load = new PageLoads;
        $load->user     = $uID;
        $load->currUser = $uID;
        $load->page     = $this->currUrl;
        $load->ip       = $_SERVER["REMOTE_ADDR"];
        $load->browser  = $GLOBALS["util"]->getBrowser();
        $load->save();
        return view('vendor.burnermap.master', [
            "request"  => $request,
            "currPage" => $this->currPage,
            "notifs"   => $this->chkNotifs($request),
            "mainout"  => $this->mainout,
            "java"     => $this->java,
            "ajax"     => $this->ajax,
            "header"   => $this->loadHeader(),
            "tots"     => $this->tots,
            "usr"      => $this->usr,
            "vars"     => $this->vars
            ]);
    }
    
    /**
     * Determine if current user is a BurnerMap Admin, with IDs set in Laravel's .env file as variable BURNER_ADMINS.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return in_array($this->usr->id, $GLOBALS["util"]->mexplode(',', env('BURNER_ADMINS')));
    }
    
    /**
     * Generate a user's profile picture with their playa name or name.
     *
     * @param  BurnerMap\Models\Burners $burner Database table record of user to be printed
     * @param  integer $w Width of image to be printed
     * @param  integer $vspace Vertical space for the image to be printed
     * @param  integer $uID Facebook user ID to be used instead of a table record
     * @return string
     */
    public function profPic($burner = null, $w = 50, $vspace = 0, $uID = -3)
    {
        $props = ' width=' . $w . ' vspace=' . $vspace . ' border=0 ';
        if (!$burner && $uID > 0) $burner = AllPastUsers::where('user', $uID)->first();
        if ($burner && isset($burner->user) && intVal($burner->user) > 0) {
            $name = $GLOBALS["util"]->formatPlayaName($this->printProfileName($burner), 15);
            $name = preg_replace("/[^a-zA-Z0-9\s@_.\-\+\(\)]/", "", $name);
            if (strlen($name) > 30) $name = substr($name, 0, 30).'...';
            return '<a href="https://www.facebook.com/app_scoped_user_id/' . $burner->user . '" target="_blank">'
                . '<img src="https://graph.facebook.com/v3.0/' . $burner->user . '/picture?type=normal"' . $props 
                . (($name != '') ? 'title="' . $name . '" alt="' . $name . '" ' : '') . '></a>';
        }
        return '<img src="/images/spacer.gif"' . $props . '>';
    }
    
    /**
     * Retrieve a users playa name or default world name.
     *
     * @param  BurnerMap\Models\Burners $burner Database table record of user to be printed
     * @return string
     */
    public function printProfileName($burner)
    {
        if (isset($burner->playaName) && trim($burner->playaName) != '') return $burner->playaName;
        elseif (isset($burner->name) && trim($burner->name) != '') return $burner->name;
        return '';
    }
    
    /**
     * Load all the current user's friends into $myInfo, as well as incoming and outgoing blocks of others.
     *
     * @return boolean
     */
    public function getAllPastFriends()
    {
        $this->myInfo->allPastFrnds = BurnerPastFriendUsers::where('user', $this->usr->id)
            ->first();
        if ($this->myInfo->allPastFrnds && (!isset($this->myInfo->allPastFrnds->tot) 
            || strtotime($this->myInfo->allPastFrnds->updated_at) < $this->cachExpir)) {
            $this->clearAllPastFriends();
        }
        if (!$this->myInfo->allPastFrnds || !isset($this->myInfo->allPastFrnds->friendUsers)) {
            $this->myInfo->allPastFrnds = new BurnerPastFriendUsers;
            $this->myInfo->allPastFrnds->user = $this->usr->id;
            $this->myInfo->allPastFrnds->friendUsers = ',';
            $this->myInfo->loadBlocks($this->usr->id);
            $empties = ['', ',,', ',0,'];
            $all = [];
            $frnds = BurnerFriends::where('user', $this->usr->id)
                ->first();
            if ($frnds && isset($frnds->friends) && !in_array(trim($frnds->friends), $empties)) {
                $all = $GLOBALS["util"]->mexplode(',', $frnds->friends);
            }
            for ($year = intVal(date("Y"))-1; $year > 2010; $year--) {
                eval("\$frnds = BurnerMap\\Models\\BurnerFriends" . $year . "::where('user', " . $this->usr->id . ")
                    ->first();");
                if ($frnds && isset($frnds->friends) && !in_array(trim($frnds->friends), $empties)) {
                    $more = $GLOBALS["util"]->mexplode(',', $frnds->friends);
                    if (sizeof($more) > 0) {
                        foreach ($more as $f) {
                            if (!in_array($f, $all)) {
                                $chk = AllPastUsers::where('user', $f)
                                    ->select('name')
                                    ->first();
                                if ($chk) $all[] = $f;
                            }
                        }
                    }
                }
            }
            $this->myInfo->allPastFrnds->tot = sizeof($all);
            if ($this->myInfo->allPastFrnds->tot > 0) {
                $this->myInfo->allPastFrnds->friendUsers = ',' . implode(',', $all) . ',';
            }
            $all = $this->myInfo->myBlocks;
            if (sizeof($this->myInfo->theirBlocks) > 0) {
                foreach ($this->myInfo->theirBlocks as $block) {
                    if (!in_array($block, $all)) $all[] = $block;
                }
            }
            $this->myInfo->allPastFrnds->hideUsers = ',' . implode(',', $all) . ',';
            $this->myInfo->allPastFrnds->save();
        }
        return true;
    }
    
    /**
     * Clear the current user's cache of all past friends
     *
     * @return boolean
     */
    public function clearAllPastFriends()
    {
        BurnerPastFriendUsers::where('user', $this->usr->id)
            ->delete();
        $this->myInfo->allPastFrnds = null;
        return true;
    }
    
    /**
     * Delete both the cache of past friends, current friend list, and caches.
     *
     * @return string
     */
    protected function clearFriendList()
    {
        $this->clearAllPastFriends();
        BurnerFriends::where('user', $this->usr->id)
            ->delete();
        eval("BurnerMap\\Models\\CacheBlobs" . $this->myInfo->userMod . "::where('user', " . $this->usr->id . ")
            ->delete();");
        return '<script type="text/javascript"> alert("Friends list cleared! Now follow the next steps '
            . 'to fully remove the app from your Facebook account and try re-connecting with BurnerMap <3"); '
            . '</script>';
    }
    
    /**
     * Clear all map caches for all of this user's friends.
     *
     * @return boolean
     */
    protected function clearFriendCaches($cacheClearUsers = [])
    {
        if (sizeof($cacheClearUsers) == 0) {
            if (!isset($this->myInfo->allPastFrnds->friendUsers)) $this->getAllPastFriends();
            $cacheClearUsers = $GLOBALS["util"]->mexplode(',', $this->myInfo->allPastFrnds->friendUsers);
        }
        /*
        $cachQry = "`friends` LIKE '%," . $this->usr->id . ",%' OR `user` IN (" . $this->usr->id
            . ((sizeof($cacheClearUsers) > 0) ? ", " . implode(", ", $cacheClearUsers) : "") . ")";
        DB::raw("DELETE FROM `CacheBlobs` WHERE " . $cachQry);
        for ($i = 0; $i < 10; $i++) DB::raw("DELETE FROM `CacheBlobs" . $i . "` WHERE " . $cachQry);
        */
        eval("BurnerMap\\Models\\CacheBlobs::whereIn('user', \$cacheClearUsers)"
            . "->orWhere('friends', 'LIKE', '%,\$this->usr->id,%')->delete();");
        for ($i = 0; $i < 10; $i++) {
            eval("BurnerMap\\Models\\CacheBlobs" . $i . "::whereIn('user', \$cacheClearUsers)"
                . "->orWhere('friends', 'LIKE', '%,\$this->usr->id,%')->delete();");
        }
        return true;
    }
    
    /**
     * Check for any standard-issue notifications this users should see, and has not.
     *
     * @return string
     */
    protected function chkNotifs(Request $request)
    {
        $ret = '';
        if ($request->has('notif') && intVal($request->get('notif')) > 0) {
            $prime = intVal($request->get('notif'));
            if ($prime < 0) {
                $prime = (-1)*$prime;
                if ($this->myBurn->messages%$prime == 0) $this->myBurn->messages = $this->myBurn->messages/$prime;
            } else {
                if ($this->myBurn->messages%$prime > 0) $this->myBurn->messages = $prime*$this->myBurn->messages;
            }
            $this->myBurn->save();
            if ($request->has('notifOnly')) exit;
        }
        if ($this->currPage == 'map') {
            if ($request->has('tickPop') && trim($request->get('tickPop')) != '') {
                $this->java .= 'window.onload = function() { Shadowbox.open({
                    player:     "iframe",
                    content:    "/tickets-instruct-' . $request->get('tickPop') . '?print=1",
                    height:     600,
                    width:      540
                    });
                };';
            }
            $notifCnt = 0;
            if ($this->archYear == '') {
                if ($this->myBurn->messages%29 > 0) {
                    $notifCnt++;
                    $ret .= view('vendor.burnermap.notification-dontate')->render();
                }
                /* if ($this->myBurn->messages%11 > 0 && $this->isAdmin()) {
                    $notifCnt++;
                    $ret .= view('vendor.burnermap.notification-github-issue')->render();
                } */
                if ($this->myBurn->messages%7 > 0) {
                    $notifCnt++;
                    $ret .= view('vendor.burnermap.notification-ticket')->render();
                }
            }
            if ($ret != '') {
                $this->java .= 'var notifTot = ' . $notifCnt . ';
                function hideNotif(n) {
                    document.getElementById(\'notif\'+n+\'\').style.display=\'none\';
                    notifTot--;
                    if (notifTot <= 0) document.getElementById(\'notifTitle\').style.display=\'none\';
                }';
                $ret = '<center><div id="notifTitle" class="condensed">NOTIFICATIONS</div>' . $ret . '</center>';
            }
        }
        return $ret;
    }
    
}
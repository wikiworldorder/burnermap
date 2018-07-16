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
    protected $usr       = null;
    protected $myBurn    = null;
    protected $myInfo    = null;
    protected $tots      = [];
    protected $vars      = [];
    
    protected $currPage  = 'welcome';
    protected $currUrl   = '';
    protected $archYear  = '';
    protected $mainout   = '';
    protected $java      = '';
    protected $ajax      = '';
    
    protected $cachExpir = 0;
    
    protected $fbFields = ['id', 'name', 'link', 'picture', 'friends'];
    protected $fbScopes = ['public_profile', 'user_friends'];
    
    function __construct()
    {
        $GLOBALS["util"] = new IncUtils;
        $this->cachExpir = mktime(0, 0, 0, date("n"), date("j")-1, date("Y"));
        return true;
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
                //->stateless()
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

    public function logout()
    {
        session()->forget('burntok');
        //Auth::logout();
        return redirect('/welcome');
    }

    public function loadPage($currPage = 'welcome')
    {
        $this->currPage = $currPage;
        if (session()->has('burntok')) {
            $tok = session()->get('burntok');
            $this->usr = Socialite::driver('facebook')
                ->fields($this->fbFields)
                ->scopes($this->fbScopes)
                ->userFromToken($tok);
        }
        if ($this->currPage == 'welcome') {
            if ($this->usr && isset($this->usr->id)) {
                return $GLOBALS["util"]->jsRedirect('/map');
            }
        } elseif ($this->currPage != 'privacy') {
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
    
    // Admin user IDs set in Laravel's .env file as variable "BURNER_ADMINS"
    public function isAdmin()
    {
        return in_array($this->usr->id, $GLOBALS["util"]->mexplode(',', env('BURNER_ADMINS')));
    }

    public function loadUserInfo()
    {
        $this->myBurn = Burners::where('user', $this->usr->id)
            ->first();
        if (!$this->myBurn) {
            $this->myBurn = new Burners;
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
        $frnds->friends = ',';
        if (isset($this->usr->user) && isset($this->usr->user["friends"]) && isset($this->usr->user["friends"]["data"])
            && sizeof($this->usr->user["friends"]["data"]) > 0) {
            foreach ($this->usr->user["friends"]["data"] as $i => $f) {
                $this->myInfo->myFriends[] = $f["id"];
            }
            $frnds->friends .= implode(',', $this->myInfo->myFriends) . ',';
        }
        $frnds->save();
        unset($this->usr->user["friends"]["data"]); // saving the memory once ids in simpler array
        return true;
    }
    
    public function profPic($burner = null, $w = 50, $vspace = 0, $uID = -3)
    {
        $props = ' width=' . $w . ' vspace=' . $vspace . ' border=0 ';
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
    
    public function printProfileName($burner)
    {
        if (isset($burner->playaName) && trim($burner->playaName) != '') return $burner->playaName;
        elseif (isset($burner->name) && trim($burner->name) != '') return $burner->name;
        return '';
    }
    
    public function getAllPastFriends(Request $request)
    {
        $this->myInfo->allPastFrnds = BurnerPastFriendUsers::where('user', $this->usr->id)
            ->first();
        if ($request->has('refresh') || !isset($this->myInfo->allPastFrnds->tot) 
            || strtotime($this->myInfo->allPastFrnds->updated_at) < $this->cachExpir) {
            BurnerPastFriendUsers::where('user', $this->usr->id)
                ->delete();
            $this->myInfo->allPastFrnds = null;
        }
        if (!$this->myInfo->allPastFrnds || !isset($this->myInfo->allPastFrnds->friendUsers)) {
            $this->myInfo->allPastFrnds = new BurnerPastFriendUsers;
            $this->myInfo->allPastFrnds->user = $this->usr->id;
            $this->myInfo->allPastFrnds->friendUsers = ',';
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
                                $fUsr = AllPastUsers::where('user', $f)
                                    ->select('name')
                                    ->first();
                                if ($fUsr) $all[] = $f;
                            }
                        }
                    }
                }
            }
            $this->myInfo->allPastFrnds->tot = sizeof($all);
            if ($this->myInfo->allPastFrnds->tot > 0) {
                $this->myInfo->allPastFrnds->friendUsers = ',' . implode(',', $all) . ',';
            }
            $this->myInfo->allPastFrnds->save();
        }
        return true;
    }
    
    protected function clearFriendList()
    {
        BurnerFriends::where('user', $this->usr->id)
            ->delete();
        BurnerPastFriendUsers::where('user', $this->usr->id)
            ->delete();
        eval("BurnerMap\\Models\\CacheBlobs" . $this->myInfo->userMod . "::where('user', " . $this->usr->id . ")
            ->delete();");
        return '<script type="text/javascript"> alert("Friends list cleared! Now follow the next steps '
            . 'to fully remove the app from your Facebook account and try re-connecting with BurnerMap <3"); '
            . '</script>';
    }
    
    // Clear all map caches for all of this user's friends
    protected function clearFriendCaches($cacheClearUsers = [])
    {
        if (sizeof($cacheClearUsers) == 0) $cacheClearUsers = $this->myInfo->myFriends;
        $cachQry = "`friends` LIKE '%," . $this->usr->id . ",%' OR `user` IN (" . $this->usr->id
            . ((sizeof($cacheClearUsers) > 0) ? ", " . implode(", ", $cacheClearUsers) : "") . ")";
        if (sizeof($cacheClearUsers) > 0) {
            foreach ($cacheClearUsers as $u) $cachQry .= " OR `friends` LIKE '%," . $u . ",%'";
        }
        DB::raw("DELETE FROM `CacheBlobs` WHERE " . $cachQry);
        for ($i = 0; $i < 10; $i++) DB::raw("DELETE FROM `CacheBlobs" . $i . "` WHERE " . $cachQry);
        return true;
    }
    
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
            if ($this->myBurn->messages%29 > 0) { // && (isAdmin() || $_GET["test29"])
                $notifCnt++;
                $ret .= view('vendor.burnermap.notification-dontate')->render();
            }
            if ($this->myBurn->messages%7 > 0) {
                $notifCnt++;
                $ret .= view('vendor.burnermap.notification-ticket')->render();
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
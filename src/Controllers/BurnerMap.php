<?php
namespace BurnerMap\Controllers;

use DB;
use Illuminate\Http\Request;

use BurnerMap\Models\Burners;
use BurnerMap\Models\BurnerCamps;
use BurnerMap\Models\BurnerVillages;
use BurnerMap\Models\OfficialCampsAPI;
use BurnerMap\Models\AllPastUsers;
use BurnerMap\Models\BurnerPastFriendUsers;
use BurnerMap\Models\BlockUsers;
use BurnerMap\Models\CoordConvert;

use BurnerMap\Models\JerkCheck;
use BurnerMap\Models\CacheAuto;
use BurnerMap\Models\PageEdits;
use BurnerMap\Models\Totals;

use BurnerMap\Controllers\BurnerVars;
use BurnerMap\Controllers\MapDeets;

class BurnerMap extends FaceController
{
    protected $map = null;
    
    public function loadVars()
    {
        $this->vars = new BurnerVars;
        return true;
    }
    
    // Functions which prep and save the Edit Page
    public function edit(Request $request)
    {
        $this->loadPage($request, 'edit');
        $this->loadVars();
        if ($this->editSave($request)) {
            $this->mainout .= '<br /><br /><center><img src="/images/burnerMapLogo-anim.gif" border=0 width=100 >'
                . '<br />... redirecting to <a href="/map?refresh=1">your map</a> ...</center><br /><br /><br /><br />'
                . '<script type="text/javascript"> setTimeout("window.location=\'/map?refresh=1\'", 100); </script>';
            return $this->printPage($request);
        }
        $campOpts = $this->printCampOpts();
        $villOpts = $this->printVillageOpts();
        file_put_contents('../public/lib/camps.js', $this->java);
        $this->java = '';
        if (intVal($this->myBurn->campID) > 0) {
            $this->myInfo->myCamp = BurnerCamps::find($this->myBurn->campID);
        }
        if (intVal($this->myBurn->villageID) > 0) {
            $this->myInfo->myVillage = BurnerVillages::find($this->myBurn->villageID);
        }
        $dateArrive = (($this->myBurn && isset($this->myBurn->dateArrive)) ? $this->myBurn->dateArrive : '');
        $dateDepart = (($this->myBurn && isset($this->myBurn->dateDepart)) ? $this->myBurn->dateDepart : '');
        $this->mainout .= view('vendor.burnermap.edit', [
            "usr"        => $this->usr,
            "myBurn"     => $this->myBurn,
            "myInfo"     => $this->myInfo,
            "vars"       => $this->vars,
            "prevUsers"  => $this->previewFriendUsers($request),
            "dateArriv"  => $this->vars->printDateOpts($dateArrive),
            "dateDepart" => $this->vars->printDateOpts($dateDepart),
            "campOpts"   => $campOpts,
            "villOpts"   => $villOpts
            ])->render();
        return $this->printPage($request);
    }
    
    protected function editSave(Request $request)
    {
        if ($request->has('sub') && $request->has('uID') && intVal($request->get('uID')) > 0) {
            $cacheClearUsers = [];
            $addyClock   = trim($request->get('addyClock'));
            $addyLetter  = trim($request->get('addyLetter'));
            $addyLetter2 = trim($request->get('addyLetter2'));
            $x = $y = $emailRemind = 0;
            if ($request->has('emailRemind') && intVal($request->get('emailRemind')) == 1) $emailRemind = 1;
            if ($addyClock != '?:??' && $addyLetter != '???') {
                $coord = CoordConvert::where('addyClock', $addyClock)
                    ->where('addyLetter', $addyLetter)
                    ->first();
                if ($coord) {
                    $x = $coord->x;
                    $y = $coord->y;
                }
            }
            
            // Storing camp info
            $upCamps = [];
            if (isset($this->myBurn->campID) && intVal($this->myBurn->campID) > 0) $upCamps[] = $this->myBurn->campID;
            $who = ((isset($this->myBurn->playaName) && trim($this->myBurn->playaName) != '') 
                ? $this->myBurn->playaName : $this->myBurn->name);
            $villageID = intVal($request->get('villageID'));
            $campID = intVal($request->get('campID'));
            $campName = (($request->has('camp')) ? strip_tags(trim($request->get('camp'))) : '');
            if ($campID == -1) $campName = '';
            if (trim($campName) != '') {
                $campRow = BurnerCamps::where('name', $campName)
                    ->orWhere('id', $campID)
                    ->first();
                if ($campRow) {
                    $campID = $campRow->id;
                    if (($addyClock != '?:??' && $addyClock != $campRow->addyClock)
                        || ($addyLetter != '???' && $addyLetter != $campRow->addyLetter)
                        || ($addyLetter2 != '???' && $addyLetter2 != $campRow->addyLetter2)
                        || (intVal($villageID) > 0 && $villageID != $campRow->villageID)) {
                        $proceedSavingChanges = true;
                        $jerkRow = JerkCheck::where('user', $this->usr->id)
                            ->first();
                        if ($jerkRow) {
                            $sameCamp = false;
                            $myCampEdits = $GLOBALS["util"]->mexplode(';;', $jerkRow->campEdits);
                            foreach ($myCampEdits as $editInfo) {
                                if (strpos($editInfo, '!!') !== false) { 
                                    $currEdit = $GLOBALS["util"]->mexplode('!!', $editInfo);
                                    if ($currEdit[0] == $campID) $sameCamp = true;
                                }
                            }
                            if (!$sameCamp) {
                                $jerkRow->campEdits .= ';;' . $campID . '!!' . time();
                                $jerkRow->alert++;
                                $jerkRow->save();
                                if ($jerkRow->alert > 3) {
                                    $GLOBALS["util"]->sessMsg .= '<br /><br /><center><span style="color: #FF0000; '
                                        . 'font-size: 16pt;"><i>Sorry, you have already set the coordinates for three '
                                        . 'different camps.</i></span></center><br /><br />';
                                    $proceedSavingChanges = false;
                                }
                            }
                        } else {
                            $jerkRow = new JerkCheck;
                            $jerkRow->user = $this->usr->id;
                            $jerkRow->campEdits = $campID . '!!' . time();
                            $jerkRow->save();
                        }
                        if ($proceedSavingChanges) {
                            BurnerCamps::find($campID)->update([
                                'addyClock'   => $addyClock,
                                'addyLetter'  => $addyLetter,
                                'addyLetter2' => $addyLetter2,
                                'x'           => $x,
                                'y'           => $y,
                                'villageID'   => $villageID,
                                'who'         => $who
                                ]);
                            $campers = Burners::where('campID', $campID)
                                ->select('user', 'addyClock', 'addyLetter', 'addyLetter2', 'x', 'y', 'villageID')
                                ->get();
                            if ($campers->isNotEmpty()) {
                                foreach ($campers as $u) {
                                    $u->addyClock   = $addyClock;
                                    $u->addyLetter  = $addyLetter;
                                    $u->addyLetter2 = $addyLetter2;
                                    $u->x           = $x;
                                    $u->y           = $y;
                                    $u->villageID   = $villageID;
                                    $u->save();
                                    $cacheClearUsers[] = $u->user;
                                }
                            }
                        }
                    }
                } else { // adding new camp
                    $campRow = new BurnerCamps;
                    $campRow->x           = $x;
                    $campRow->y           = $y;
                    $campRow->addyClock   = $addyClock;
                    $campRow->addyLetter  = $addyLetter;
                    $campRow->addyLetter2 = $addyLetter2;
                    $campRow->size        = 1;
                    $campRow->who         = $who;
                    $campRow->villageID   = $villageID;
                    $campRow->apiID       = -3;
                    $campRow->save();
                    $campRow->name        = $campName;
                    $campRow->save();
                    $campID = $campRow->id;
                }
                DB::table('CacheAuto')->truncate();
            }
            
            // Finally storing burner profile changes
            $prevName = $this->myBurn->playaName;
            if (intVal($this->myBurn->opts) <= 0) $this->myBurn->opts = 1;
            $notes = '';
            if ($request->has('notes')) {
                $notes = strip_tags($request->notes, '<b><i><br>');
                $notes = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $notes);
            }
            $this->myBurn->opts = $GLOBALS["util"]->chkReqOpts($request, $this->myBurn->opts, 'shareWithCamp', 3);
            $this->myBurn->opts = $GLOBALS["util"]->chkReqOpts($request, $this->myBurn->opts, 'shareWithVill', 13);
            $this->myBurn->playaName   = (($request->has('playaName')) ? strip_tags($request->get('playaName')) : '');
            $this->myBurn->email       = (($request->has('email')) ? $request->get('email') : '');
            $this->myBurn->notes       = $notes;
            $this->myBurn->campID      = $campID;
            $this->myBurn->villageID   = $villageID;
            $this->myBurn->addyClock   = $addyClock;
            $this->myBurn->addyLetter  = $addyLetter;
            $this->myBurn->addyLetter2 = $addyLetter2;
            $this->myBurn->x           = $x;
            $this->myBurn->y           = $y;
            $this->myBurn->emailRemind = $emailRemind;
            $this->myBurn->browser     = $GLOBALS["util"]->getBrowser();
            $this->myBurn->ip          = $_SERVER["REMOTE_ADDR"];
            $this->myBurn->dateArrive  = (($request->has('dateArrive')) ? $request->get('dateArrive') : '');
            $this->myBurn->dateDepart  = (($request->has('dateDepart')) ? $request->get('dateDepart') : '');
            $this->myBurn->yearStatus  = (($request->has('burnThisYear') && intVal($request->burnThisYear) == 1) 
                ? 'Skipping' : 'Participating');
            $this->myBurn->edits++;
            $this->myBurn->save();
            if ($this->myBurn->edits == 1) session()->put('firstFormSubmission', true);
            if ($prevName != $this->myBurn->playaName) {
                AllPastUsers::where('user', $this->usr->id)
                    ->update([ 'playaName' => $this->myBurn->playaName ]);
            }
            $edit = new PageEdits;
            $edit->user = $this->usr->id;
            $edit->dump = $this->myBurn->playaName . ';' . $this->myBurn->email . ';' . $this->myBurn->notes . ';' 
                . $this->myBurn->camp . ';' . $this->myBurn->campID . ';' . $this->myBurn->villageID . ';' 
                . $this->myBurn->addyClock . ';' . $this->myBurn->addyLetter . ';' . $this->myBurn->addyLetter2 . ';'
                . $this->myBurn->x . ';' . $this->myBurn->y . ';' . $this->myBurn->emailRemind . ';'
                . $this->myBurn->browser . ';' . $this->myBurn->ip . ';' . $this->myBurn->dateArrive . ';'
                . $this->myBurn->dateDepart . ';' . $this->myBurn->yearStatus . ';' . $this->myBurn->edits;
            $edit->save();
            $this->clearFriendCaches();
            if ($campID > 0 && !in_array($campID, $upCamps)) $upCamps[] = $campID;
            if (sizeof($upCamps) > 0) {
                foreach ($upCamps as $cID) {
                    $size = Burners::where('campID', $cID)->count();
                    BurnerCamps::find($cID)->update([ 'size' => $size ]);
                }
            }
            $this->myBurn->camp = $campName;
            $this->myBurn->save();
            return true;
        }
        return false;
    }
    
    protected function previewFriendUsers(Request $request)
    {
        eval("\$cache = BurnerMap\\Models\\CacheBlobs" . $this->myInfo->userMod . "::where('user', "
            . $this->usr->id . ")->where('type', 'previewFriends')->first();");
        if (!$request->has('refresh') && $cache && isset($cache->blobber) && trim($cache->blobber) != ''
            && $this->cachExpir < strtotime($cache->updated_at)) {
            return $cache->blobber;
        }
        if (!$cache) {
            eval("\$cache = new BurnerMap\\Models\\CacheBlobs" . $this->myInfo->userMod . ";");
            $cache->user = $this->usr->id;
            $cache->type = 'previewFriends';
        }
        if ($request->has('refresh')) $this->clearAllPastFriends();
        $this->getAllPastFriends();
        $max = 10;
        $usersDone = [];
        $cache->blobber = '<table border=0 width=100% class="burnFriends" ><tr>' . "\n";
        $frnds = Burners::whereIn('user', $this->myInfo->getMapFriends())
            ->select('user', 'name', 'playaName')
            ->orderBy('updated_at', 'desc')
            ->limit($max)
            ->get();
        if ($frnds->isNotEmpty()) {
            foreach ($frnds as $i => $f) {
                if (sizeof($usersDone) < $max) {
                    $cache->blobber .= '<td style="border: 0px none;">' . $this->profPic($f, 36) . '</td>' . "\n";
                    $usersDone[] = $f->user;
                }
            }
        }
        $chk = AllPastUsers::whereIn('user', $this->myInfo->getMapFriends())
            ->whereNotIn('user', $usersDone)
            ->orderBy('updated_at', 'desc')
            ->limit($max-sizeof($usersDone))
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $f) {
                $cache->blobber .= '<td style="border: 0px none;">' . $this->profPic($f, 36) . '</td>'."\n";
                $usersDone[] = $f->user;
            }
        }
        if (sizeof($usersDone) > 0) {
            while (sizeof($usersDone) < $max) {
                $cache->blobber .= '<td style="border: 0px none;">' . $this->profPic(null, 36) . '</td>'."\n";
                $usersDone[] = 0;
            }
        }
        $cache->blobber .= '</tr></table>';
        $cache->blobber = $this->map->skips[] = view('vendor.burnermap.edit-previous-users', [
            "tot"       => $this->myInfo->allPastFrnds->tot,
            "usersDone" => $usersDone,
            "blobber"   => $cache->blobber
            ])->render();
        $cache->save();
        return $cache->blobber;
    }
    
    protected function printCampOpts()
    {
        $ret = '';
        $this->myInfo->myCampHasCoords = false;
        $chk = BurnerCamps::where('name', 'NOT LIKE', '')
            ->orderBy('name')
            ->get();
        if ($chk->isNotEmpty()) {
            $cnt = 3;
            foreach ($chk as $row) {
                $cnt++;
                if ($row->id == $this->myBurn->campID) {
                    if ($row->addyClock != '?:??' && $row->addyLetter != '???') $this->myInfo->myCampHasCoords = true;
                }
                $nameShort = $row->name;
                if (strlen($nameShort) > 50) $nameShort = substr($nameShort, 0, 50) . '...';
                $ret .= '<option value="' . $row->id . '" ' . (($this->myBurn["campID"] == $row->id) ? 'SELECTED' : '')
                    . ' >' . $nameShort . ' (' . $row->size . ') - ' . $row->addyClock . ' & ' . $row->addyLetter 
                    . '</option>';
                $this->java .= 'campInfo[' . $row->id . '] = new Array(' . json_encode($nameShort) . ', "' . $row->x
                    . '", "' . $row->y . '", "' . $row->addyClock . '", ' . json_encode($row->addyLetter) . ', "'
                    . $row->addyLetter2 . '", ' . (($row->who == '???') ? '"A campmate"' : json_encode($row->who)) 
                    . ', ' . $row->villageID . ', "' . $cnt . '");' . "\n";
            }
        }
        return $ret;
    }
    
    protected function printVillageOpts()
    {
        $ret = '';
        $chk = BurnerVillages::where('name', 'NOT LIKE', '')
            ->orderBy('name')
            ->get();
        if ($chk->isNotEmpty()) {
            $cnt = 0;
            foreach ($chk as $row) {
                $cnt++;
                $ret .= '<option value="' . $row->id . '" ' 
                    . ((isset($this->myBurn->villageID) && $this->myBurn->villageID == $row->id) 
                        ? 'SELECTED' : '') . ' >' . $row->name . '</option>';
                $this->java .= 'villageInfo[' . $row->id . '] = new Array(' . json_encode($row["name"]) . ', "' . $cnt
                    . '");' . "\n";
            }
        }
        return $ret;
    }
    
    // Functions which prep and save the Map Page
    public function map(Request $request)
    {
        $this->loadPage($request, 'map');
        $this->loadVars();
        if ($this->archYear == '' && (!isset($this->myBurn->edits) || intVal($this->myBurn->edits) == 0)) {
            return redirect('/edit');
        }
        if ($request->has('json')) {
            return $this->jsonFriends($request);
        }
        if ($request->has('excel')) {
            return $this->excelFriends($request);
        }
        if ($request->has('listAll')) {
            return $this->camps($request);
        }
        if ($request->has('sub') && $request->has('uID') && intVal($request->get('uID')) == $this->usr->id
            && $request->has('mini') && $request->has('privNotes')) {
            $this->myBurn->privateNotes = $request->get('privateNotes');
            $this->myBurn->save();
            exit;
        }
        $isPrint = ($request->has('print') && intVal($request->get('print')) > 0);
        $isExcel = ($request->has('excel') && intVal($request->get('excel')) > 0);
        if ($request->has('clearFriendList') && intVal($request->get('clearFriendList')) == 1) {
            $this->mainout .= $this->clearFriendList();
        } else {
            
            // First, check for a cache of the requested map
            if ($request->has('remind')) {
                $this->currUrl = '?remind=1';
            } else {
                $this->currUrl = (($isPrint) ? '?print=1' : (($isExcel) ? '?excel=1' : '?list=1'));
                if ($this->archYear != '') $this->currUrl .= '&arch=' . $this->archYear;
                if ($request->has('zoom')) $this->currUrl .= '&zoom=1';
            }
            eval("\$cache = BurnerMap\\Models\\CacheBlobs" . $this->myInfo->userMod . "::where('user', "
                . $this->usr->id . ")->where('type', '" . $this->currUrl . "')->first();");
            if (!$request->has('refresh') && $cache && isset($cache->blobber) && trim($cache->blobber) != '') {
                $this->mainout .= '<div>' . $cache->blobber . '</div>' . "\n" 
                    . '<!-- Hurray! saved some database power by displaying a cache this time -->' . "\n";
                $this->mapPostCache($isPrint);
                return $this->printPage($request);
            }
            if ($request->has('refresh')) {
                $this->clearAllPastFriends();
            }
            $this->getAllPastFriends();
            if (!$cache) {
                eval("\$cache = new BurnerMap\\Models\\CacheBlobs" . $this->myInfo->userMod . ";");
                $cache->user = $this->usr->id;
                $cache->type = $this->currUrl;
                $cache->friends = $this->myInfo->allPastFrnds->friendUsers;
            }
            $cache->blobber = '';
            if ($this->archYear != '') {
                $cache->blobber .= '<center><h3 class="archYearLabel"><i>Your Archival Map From ' . $this->archYear
                    . '<br /><span class="f8 nobld">(time travellingly includes new friends)</span></i></h3></center>';
            }
            $this->map = new MapDeets;
            $this->map->loadCampDeets($this->archYear);
            
//if ($GLOBALS["util"]->isAdmin) { echo '<pre>'; print_r($this->myInfo->myFriends); echo '</pre>'; }
            
            // Construct queries to find friends to map
            $changeCutoff = (($this->archYear != '') ? $this->archYear : date("Y")) . '-02-01 00:00:00';
            $qryBase = "\$resFriends = BurnerMap\\Models\\Burners" . $this->archYear 
                . "::where('yearStatus', 'NOT LIKE', 'None')";
            $qryWhereIn = "->whereIn('user', \$this->myInfo->getMapFriends(\$this->usr->id))";
            if ($this->myBurn->yearStatus != 'Skipping' 
                && (intVal($this->myBurn->campID) > 0 || intVal($this->myBurn->villageID) > 0)) {
                $qryBase .= "->where(function (\$query) { \$query" . $qryWhereIn;
                if (intVal($this->myBurn->campID) > 0) {
                    $qryBase .= "->orWhere(function (\$query2) { \$query2->where('yearStatus', 'Participating')"
                        . "->where('campID', " . $this->myBurn->campID . ")->whereRaw('opts%3 = 0'); })";
                }
                if (intVal($this->myBurn->villageID) > 0) {
                    $qryBase .= "->orWhere(function (\$query3) { \$query3->where('yearStatus', 'Participating')"
                        . "->where('villageID', " . $this->myBurn->villageID . ")->whereRaw('opts%13 = 0'); })";
                }
                $qryBase .= "; })";
            } else {
                $qryBase .= $qryWhereIn;
            }
            $qryOrder = "->orderBy('addyClock', 'asc')->orderBy('addyLetter', 'asc')->orderBy('camp', 'asc')"
                . "->orderBy('name', 'asc')->get();";
            $qrys = [
                "->where('campID', '>', 0)->whereNotIn('addyClock', [" . $this->map->specialTime . "])",
                "->where('campID', '>', 0)->whereIn('addyClock', [" . $this->map->specialTime . "])",
                "->where('campID', '<', 1)"
                ];
            foreach ($qrys as $q => $qry) {
                eval($qryBase . $qry . $qryOrder);
                if ($resFriends->isNotEmpty()) {
                    foreach ($resFriends as $f => $friend) {
                        $this->map->friendDone[] = $friend->user;
                        $this->map->resCnt++;
                        if (strtotime($friend->updated_at) > strtotime($changeCutoff)) {
                            $this->map->resCnt2b++;
                            if (strpos($this->myInfo->allPastFrnds->friendUsers, ',' . $friend->user . ',') !== false) {
                                $this->map->resCnt2c++;
                            }
                        }
                        if ($friend->yearStatus == 'Skipping') {
                            if ($isPrint) {
                                $this->map->skips[] = $GLOBALS["util"]->prntFrmtName($friend);
                            } else {
                                $this->map->skips[] = view('vendor.burnermap.map-friend-skipping', [
                                    "friend"  => $friend,
                                    "profPic" => $this->profPic($friend, 50, 8),
                                    "skipCnt" => sizeof($this->map->skips)
                                    ])->render();
                            }
                        } elseif ($friend->yearStatus == 'Participating') {
                            $this->map->resCnt2++;
                            if ($friend->campID > 0) {
                                list($x, $y) = $this->map->getXY($this->map->campDeets[$friend->campID]->x,
                                    $this->map->campDeets[$friend->campID]->y, $request->has('zoom'));
                                $this->map->campDeets[$friend->campID]->x = $x;
                                $this->map->campDeets[$friend->campID]->y = $y;
                                $firstCamper = false;
                                if (!isset($this->map->campGraph[$friend->campID])) {
                                    $this->map->resCnt++;
                                    $this->map->addCamp($friend->campID, $x, $y, $isPrint);
                                    $firstCamper = true;
                                }
                                $this->map->camps[$friend->campID] .= view('vendor.burnermap.map-camper-row', [
                                    "myBurn"      => $this->myBurn,
                                    "friend"      => $friend,
                                    "profPic"     => $this->profPic($friend, 50, 8),
                                    "firstCamper" => $firstCamper,
                                    "tickets"     => $this->getRightColTicket($friend, $this->map->resCnt),
                                    "canAdd"      => $this->canAddFriend($friend),
                                    "isPrint"     => $isPrint
                                    ])->render();
                                if (!$isPrint) {
                                    $this->map->campGraph[$friend->campID][3] 
                                        .= view('vendor.burnermap.map-camp-plot-friend', [
                                        "friend"      => $friend,
                                        "profPic"     => $this->profPic($friend, 25),
                                        "firstCamper" => $firstCamper
                                        ])->render();
                                }
                            } else { // no camp
                                $this->map->cnt++;
                                list($x, $y) = $this->map->getXY($friend->x, $friend->y, $request->has('zoom'));
                                if ($friend->addyClock == '?:??' || $friend->addyLetter == '???') {
                                    if ($isPrint) {
                                        $this->map->losts[] = $GLOBALS["util"]->prntFrmtName($friend);
                                    } else {
                                        $this->map->losts[] = view('vendor.burnermap.map-noncamper-row', [
                                            "cnt"     => $this->map->cnt,
                                            "friend"  => $friend,
                                            "profPic" => $this->profPic($friend, 50, 8),
                                            "first"   => (sizeof($this->map->losts) == 0),
                                            "tickets" => $this->getRightColTicket($friend, $this->map->resCnt)
                                            ])->render();
                                    }
                                } else {
                                    $this->map->solos[] = view('vendor.burnermap.map-noncamper-row', [
                                        "cnt"     => $this->map->cnt,
                                        "friend"  => $friend,
                                        "profPic" => $this->profPic($friend, 50, 8),
                                        "first"   => (sizeof($this->map->solos) == 0),
                                        "tickets" => $this->getRightColTicket($friend, $this->map->resCnt),
                                        "isPrint" => $isPrint
                                        ])->render();
                                }
                                $this->map->plotNonCamper($friend, $this->profPic($friend, 25), $x, $y);
                            }
                        }
                        if ($isPrint && trim($friend->notes) != '') {
                            $this->map->printNotes[] = view('vendor.burnermap.map-print-notes', [
                                "friend" => $friend
                                ])->render();
                        }
                    }
                }
                unset($resFriends);
            }
            
            if ($this->myInfo->allPastFrnds->tot > 0 && !$isPrint && $this->archYear == '') {
                $absentList = ',' . implode(',', $this->myInfo->getMapFriends($this->usr->id)) . ',';
                if (sizeof($this->map->friendDone) > 0) {
                    foreach ($this->map->friendDone as $f) $absentList = str_replace(',' . $f . ',', ',', $absentList);
                }
                $chk = AllPastUsers::whereIn('user', $GLOBALS["util"]->mexplode(',', $absentList))
                    ->select('user', 'name', 'playaName')
                    ->orderBy('name', 'asc')
                    ->get();
                if ($chk->isNotEmpty()) {
                    foreach ($chk as $friend) {
                        if ($friend->user > 0) {
                            $this->map->absents[] = view('vendor.burnermap.map-absent', [
                                "friend"    => $friend,
                                "profPic"   => $this->profPic($friend, 50, 8),
                                "absentCnt" => sizeof($this->map->absents)
                                ])->render();
                        }
                    }
                }
            }
            
            if (!$isExcel) {
                if ($isPrint) {
                    $this->map->campsHalf = floor(sizeof($this->map->campOrd)*2/3);
                    // make this smarter, dynamic
                }
                if (!$request->has('remind')) {
                    $this->map->plotCampDeets($request->has('zoom'));
                    $this->map->fullPlot = view('vendor.burnermap.map-plots', [
                        "myInfo"     => $this->myInfo,
                        "vars"       => $this->vars,
                        "map"        => $this->map,
                        "request"    => $request,
                        "archYear"   => $this->archYear,
                        "totsLabels" => (($request->has('all')) ? $this->map->resCnt2 . ' burners' 
                            : $this->map->resCnt2c . ' of your friends'),
                        "currUrl"    => $this->currUrl,
                        "isPrint"    => $isPrint
                    ])->render();
                }
                $this->mainout .= view('vendor.burnermap.map' . (($isPrint) ? '-print' : ''), [
                    "usr"     => $this->usr,
                    "myBurn"  => $this->myBurn,
                    "myInfo"  => $this->myInfo,
                    "vars"    => $this->vars,
                    "map"     => $this->map,
                    "tots"    => $this->tots,
                    "request" => $request
                ])->render();
                $cache->blobber .= $this->mainout;
                if (!$isPrint) {
                    $this->java .= 'plotCnt = ' . $this->map->cnt . ';';
                    $this->ajax .= $this->map->ajax;
                    $cache->blobber .= '<script type="text/javascript">' . $this->java
                        . '$(document).ready(function(){ ' . ((isset($this->ajax)) ? $this->ajax : '') . ' }); '
                        . '</script>';
                }
                $cache->save();
                $this->java = $this->ajax = '';
                $this->mainout = $cache->blobber;
                unset($cache);
            }
        }
        $this->mapPostCache($isPrint);
        return $this->printPage($request);
    }
    
    protected function mapPostCache($isPrint)
    {
        if (!$isPrint) {
            $this->mainout .= view('vendor.burnermap.map-footer', [
                "user"     => $this->usr->id,
                "myBurn"   => $this->myBurn,
                "archYear" => $this->archYear
                ])->render();
        }
        return true;
    }
    
    public function blockers(Request $request)
    {
        $this->loadPage($request, 'map');
        $this->getAllPastFriends();
        $this->myInfo->loadBlocks($this->usr->id);
        $all = AllPastUsers::whereIn('user', $GLOBALS["util"]->mexplode(',', $this->myInfo->allPastFrnds->friendUsers))
            ->orderBy('name', 'asc')
            ->orderBy('playaName', 'asc')
            ->get();
        if ($request->has('sub')) {
            $clearUsers = $this->myInfo->myBlocks;
            $chk = BlockUsers::where('user', $this->usr->id)
                ->first();
            if ($request->has('blockers') && sizeof($request->get('blockers')) > 0) {
                if (!$chk) {
                    $chk = new BlockUsers;
                    $chk->user = $this->usr->id;
                }
                $chk->blocks = ',';
                foreach ($request->get('blockers') as $blockInd) {
                    $chk->blocks .= $all[$blockInd]->user . ',';
                    $clearUsers[] = $all[$blockInd]->user;
                }
                $chk->save();
            } elseif ($chk) {
                BlockUsers::where('user', $this->usr->id)
                    ->delete();
            }
            // Going ahead and clearing all caches 
            BurnerPastFriendUsers::whereIn('user', $clearUsers)
                ->delete();
            DB::table('CacheBlobs')->truncate();
            for ($i = 0; $i < 10; $i++) DB::table('CacheBlobs' . $i)->truncate();
            return redirect('/map?refresh=1');
        }
        $this->mainout = view('vendor.burnermap.map-blockers', [
            "all"      => $all,
            "myBlocks" => $this->myInfo->myBlocks
            ])->render();
        return $this->printPage($request);
    }
    
    protected function canAddFriend($friend)
    {
        return ($friend->user != $this->myBurn->user && !in_array($friend->user, $this->myInfo->myFriends)
            && strpos($this->myInfo->allPastFrnds->friendUsers, ',' . $friend->user . ',') === false
            && ($friend->campID == $this->myBurn->campID || $friend->villageID == $this->myBurn->villageID));
    }
    
    protected function getRightColTicket($friend, $cntTot)
	{
	    return view('vendor.burnermap.map-friend-ticket', [
            "user"   => $this->usr->id,
            "myBurn" => $this->myBurn,
            "friend" => $friend,
            "cntTot" => $cntTot
            ])->render();
	}
    
    protected function jsonFriends(Request $request)
    {
        $data = [];
        $chk = DB::table('Burners')
            ->leftJoin('BurnerCamps', 'Burners.campID', '=', 'BurnerCamps.id')
            ->leftJoin('OfficialCampsAPI', 'BurnerCamps.apiID', '=', 'OfficialCampsAPI.id')
            ->whereIn('Burners.user', $this->myInfo->getMapFriends($this->usr->id))
            ->where('edits', '>', 0)
            ->orderBy('Burners.name', 'asc')
            ->select('Burners.*', 'OfficialCampsAPI.uid')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $i => $friend) {
                $data[] = [
                    "name" => ((trim($friend->playaName) != '') 
                        ? $friend->playaName . ' (' . $friend->name . ')' : $friend->name),
                    "camp" => ((trim($friend->camp) != '') ? $friend->camp : ''),
                    "campUID" => ((isset($friend->uid)) ? $friend->uid : ''),
                    "addyClock"    => $friend->addyClock,
                    "addyLetter"   => $friend->addyLetter,
                    "frontage"     => $friend->addyLetter2,
                    "datesOnPlaya" => $friend->dateArrive . '-' . $friend->dateDepart,
                    "notes"        => $friend->notes
                ];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function excelFriends(Request $request)
    {
        $filename = 'FriendList-'.date("Y-m-d").'.xls';
        $innerTable = '<tr><td>Mailing Address Line 1</td><td>Address Line 2</td><td>Address Line 3</td></tr>';
        eval("\$chk = BurnerMap\\Models\\Burners" . $this->archYear . "::where('edits', '>', 0)->"
            . "where('addyLetter', 'NOT LIKE', '???')->where('addyClock', 'NOT LIKE', '?:??')->whereIn('user', "
            . "\$this->myInfo->getMapFriends(\$this->usr->id))->orderBy('name', 'asc')->get();");
        if ($chk->isNotEmpty()) {
            foreach ($chk as $i => $friend) {
                $innerTable .= '<tr><td>' . ((trim($friend->playaName) != '') ? $friend->playaName . ' (' 
                    . $friend->name . ')' : $friend->name) . ', ' . ((trim($friend->camp) != '') ? $friend->camp . ', '
                    : '') . $friend->addyClock . ' & ' . $friend->addyLetter . ((trim($friend->addyLetter2) != '' 
                    && $friend->addyLetter2 != '???') ? ' ' . $friend->addyLetter2 : '')
                    . '</td><td>BRCPO9</td><td>Black Rock City, NV 89412</td></tr>'; // Gerlach NV 89412-0149
            }
        }
        return $GLOBALS["util"]->exportExcel($innerTable, $filename);
    }
    
    protected function camps(Request $request)
    {
        $isZoom = $request->has('zoom');
        $isPrint = $request->has('print');
        $isExcel = ($request->has('excel') || $request->has('xls'));
        $listAll = intVal($request->get('listAll'));
        $this->currUrl = '?listAll=' . $listAll
            . (($isPrint) ? '&print=1' : (($isExcel) ? '&excel=1' : '')) . (($request->has('zoom')) ? '&zoom=1' : '');
        eval("\$cache = BurnerMap\\Models\\CacheBlobs" . $this->myInfo->userMod . "::where('user', 0)->where('type', '"
            . $this->currUrl . "')->first();");
        if (!$request->has('refresh') && $cache && isset($cache->blobber) && trim($cache->blobber) != '') {
            $this->mainout .= '<div>' . $cache->blobber . '</div>' . "\n" 
                . '<!-- Hurray! saved some database power by displaying a cache this time -->' . "\n";
            return $this->printPage($request);
        }
        if (!$cache) {
            eval("\$cache = new BurnerMap\\Models\\CacheBlobs" . $this->myInfo->userMod . ";");
            $cache->user = 0;
            $cache->type = $this->currUrl;
        }
        $cache->blobber = '';
        
        $this->map = new MapDeets;
        $this->map->loadCampDeets();
        $this->map->plotAllCamps($isPrint, $isZoom);
        $this->map->listAllCamps($listAll);
        if (!$isExcel) {
            $cache->blobber .= view('vendor.burnermap.camps', [
                "usr"        => $this->usr,
                "myBurn"     => $this->myBurn,
                "myInfo"     => $this->myInfo,
                "vars"       => $this->vars,
                "map"        => $this->map,
                "isZoom"     => $isZoom,
                "isPrint"    => $isPrint,
                "listAll"    => $listAll
                ])->render();
        } else {
            return $this->map->excelAllCamps($listAll);
        }
        if (!$isPrint) {
            $this->java .= 'plotCnt = ' . $this->map->cnt . ';';
            $this->ajax .= $this->map->ajax;
            $cache->blobber .= '<script type="text/javascript">' . $this->java
                . '$(document).ready(function(){ ' . ((isset($this->ajax)) ? $this->ajax : '') . ' }); '
                . '</script>';
        }
        $cache->save();
        $this->java = $this->ajax = '';
        $this->mainout = $cache->blobber;
        unset($cache);
        
        return $this->printPage($request);
    }
    
    public function jsonAllCamps(Request $request)
    {
        $this->loadPage($request, 'json');
        $this->map = new MapDeets;
        return $this->map->jsonAllCamps(($request->has('year')) ? intVal($request->get('year')) : intVal(date("Y")));
    }
    
}
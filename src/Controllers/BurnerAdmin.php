<?php
namespace BurnerMap\Controllers;

use DB;
use File;
use Illuminate\Http\Request;

use BurnerMap\Models\AllPastUsers;
use BurnerMap\Models\Burners;
use BurnerMap\Models\BurnerCamps;
use BurnerMap\Models\BurnerVillages;
use BurnerMap\Models\CoordConvert;
use BurnerMap\Models\PageEdits;
use BurnerMap\Models\PageLoads;
use BurnerMap\Models\PageStats;
use BurnerMap\Models\TextSettings;
use BurnerMap\Models\Totals;

use BurnerMap\Controllers\FaceController;
use BurnerMap\Controllers\BurnerVars;
use BurnerMap\Controllers\MapDeets;

class BurnerAdmin extends FaceController
{
    public function dashboard(Request $request)
    {
        $this->loadPage($request, 'admin');
        $msg = $this->dataChecks($request);
        // ugh, why couldn't i figure out a simple DISTINCT query
        $editUs = [];
        $edits = PageEdits::select('user')->get();
        if ($edits->isNotEmpty()) {
            foreach ($edits as $e) {
                if (!in_array($e->user, $editUs)) $editUs[] = $e->user;
            }
        }
        $this->mainout .= view('vendor.burnermap.admin.dashboard', [
            "msg"            => $msg,
            "graphStats"     => $this->graphStats(),
            "plotAll"        => $this->plotAllYear(),
            "totUsers"       => Burners::count(),
            "totActiveUsers" => sizeof($editUs)
            ])->render();
        return $this->printPage($request);
    }
    
    protected function dataChecks(Request $request)
    {
        $msg = '';
        $chk = BurnerCamps::where('name', 'LIKE', ' %')
            ->orWhere('name', 'LIKE', '% ')
            ->select('id', 'name')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $camp) {
                if ($camp->name != trim($camp->name)) {
                    $camp->name = trim($camp->name);
                    $camp->save();
                    $msg = 'camp name fixed ' . $camp->name . '<br />';
                }
            }
        }
        if ($request->has('refresh')) {
            DB::table('CacheBlobs')->truncate();
            for ($i = 0; $i < 10; $i++) DB::table('CacheBlobs' . $i)->truncate();
            DB::raw("UPDATE `Burners` u JOIN `BurnerCamps` c ON (u.`campID` = c.`id`) SET u.`camp` = c.`name`, "
                . "u.`addyClock` = c.`addyClock`, u.`addyLetter` = c.`addyLetter`, u.`addyLetter2` = c.`addyLetter2`, "
                . "u.`x` = c.`x`, u.`y` = c.`y`, u.`villageID` = c.`villageID` WHERE u.`campID` > '0'");
        }
        $camps = [];
        $chk = Burners::where('campID', '>', 0)
            ->select('campID')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $user) {
                if (!isset($camps[$user->campID])) $camps[$user->campID] = 1;
                else $camps[$user->campID]++;
            }
            foreach ($camps as $campID => $size) {
                BurnerCamps::find($campID)->update([ 'size' => $size ]);
            }
        }
        return $msg;
    }
    
    protected function graphStats()
    {
        $statsToday = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
        $currDay = mktime(0, 0, 0, date("n")-2, date("j"), date("Y"));
        $dataLines = []; // [0] => loadsU, [1] => loads, [2] => editsU, [3] => edits
        while ($currDay <= $statsToday) {
            $dataLines[date("Y-m-d", $currDay)] = [0, 0, 0, 0, 0]; // l, lU, e, eU, newU
            $currDay = mktime(0, 0, 0, date("n", $currDay), date("j", $currDay)+1, date("Y", $currDay));
        }
        $currDay = mktime(0, 0, 0, date("n")-2, date("j"), date("Y"));
        $chk = PageStats::where('day', '>', date("Y-m-d", $currDay))
            ->where('day', '<=', date("Y-m-d"))
            ->orderBy('day', 'asc')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $s) $dataLines[$s->day] = [$s->loads, $s->loadsU, $s->edits, $s->editsU, $s->newUsers];
        }
        while ($currDay <= $statsToday) {
            $day = date("Y-m-d", $currDay);
            if (!isset($dataLines[$day]) || sizeof($dataLines[$day]) == 0 || $day == date("Y-m-d", $statsToday)) {
                $dataLines[$day] = [0, 0, 0, 0, 0];
                $uNiques = [ [], [] ]; // loadsU, editsU
                $chk = PageLoads::where('created_at', '>=', date("Y-m-d", $currDay) . ' 00:00:00')
                    ->where('created_at', '<=', date("Y-m-d", $currDay) . ' 23:59:59')
                    ->get();
                if ($chk->isNotEmpty()) {
                    foreach ($chk as $l) {
                        $dataLines[$day][0]++;
                        if (!isset($uNiques[0][$l->user])) { 
                            $uNiques[0][$l->user] = true;
                            $dataLines[$day][1]++;
                        }
                    }
                }
                $chk = PageEdits::where('created_at', '>=', date("Y-m-d", $currDay) . ' 00:00:00')
                    ->where('created_at', '<=', date("Y-m-d", $currDay) . ' 23:59:59')
                    ->get();
                if ($chk->isNotEmpty()) {
                    foreach ($chk as $e) {
                        $dataLines[$day][2]++;
                        if (!isset($uNiques[1][$e->user])) { 
                            $uNiques[1][$e->user] = true;
                            $dataLines[$day][3]++;
                        }
                    }
                }
                $dataLines[$day][4] = Burners::where('created_at', '>=', date("Y-m-d", $currDay) . ' 00:00:00')
                    ->where('created_at', '<=', date("Y-m-d", $currDay) . ' 23:59:59')
                    ->count();
                $stat = PageStats::where('day', $day)
                    ->first();
                if (!$stat) $stat = new PageStats;
                $stat->day      = $day;
                $stat->loads    = $dataLines[$day][0];
                $stat->loadsU   = $dataLines[$day][1];
                $stat->edits    = $dataLines[$day][2];
                $stat->editsU   = $dataLines[$day][3];
                $stat->newUsers = $dataLines[$day][4];
                $stat->save();
            }
            $currDay = mktime(0, 0, 0, date("n", $currDay), date("j", $currDay)+1, date("Y", $currDay));
        }
        $dataLineTxt = ['', '', '', '', ''];
        foreach ($dataLines as $d => $l) {
            $dataLineTxt[0] .= ', [gd(' . str_replace('-', ', ', $d) . '), '.($l[0]/10).']';
            $dataLineTxt[1] .= ', [gd(' . str_replace('-', ', ', $d) . '), '.$l[1].']';
            $dataLineTxt[2] .= ', [gd(' . str_replace('-', ', ', $d) . '), '.$l[2].']';
            $dataLineTxt[3] .= ', [gd(' . str_replace('-', ', ', $d) . '), '.$l[3].']';
            $dataLineTxt[4] .= ', [gd(' . str_replace('-', ', ', $d) . '), '.$l[4].']';
        }
        return view('vendor.burnermap.admin.dashboard-graph-stats', [
            "dataLineTxt" => $dataLineTxt
            ])->render();
    }
    
    protected function plotAllYear()
    {
        $this->map = new MapDeets;
        return view('vendor.burnermap.admin.plot-all-this-year', [
            "users" => Burners::where('x', '>', 0)
                ->where('y', '>', 0)
                ->orderBy('addyLetter', 'asc')
                ->orderBy('addyClock', 'asc')
                ->get(),
            "pointOffX" => $this->map->pointOffX,
            "pointOffY" => $this->map->pointOffY
            ])->render();
    }
    
    public function mergeCamps(Request $request)
    {
        $this->loadPage($request, 'admin');
        $msg = '';
        if ($request->has('subMerge') && sizeof($request->get('merger1')) > 0 && sizeof($request->get('merger2')) > 0) {
            $merger1    = $request->get('merger1');
            $merger2    = $request->get('merger2');
            $mergerAddy = $request->get('mergerAddy');
            $row = BurnerCamps::find($merger2[0]);
            if ($row) {
                if (sizeof($mergerAddy) > 0 && $mergerAddy[0] > 0) {
                    $rowTmp = BurnerCamps::find($mergerAddy[0]);
                    if ($rowTmp) {
                        $row->x           = $rowTmp->x;
                        $row->y           = $rowTmp->y;
                        $row->addyClock   = $rowTmp->addyClock;
                        $row->addyLetter  = $rowTmp->addyLetter;
                        $row->addyLetter2 = $rowTmp->addyLetter2;
                        $row->save();
                    }
                }
                if (trim($row->apiID) == '' || trim($row->apiID) == '-3') {
                    $rowTmp = BurnerCamps::select('id', 'apiID')
                        ->whereIn('id', $merger1)
                        ->whereNotNull('apiID')
                        ->where('apiID', 'NOT LIKE', '')
                        ->where('apiID', 'NOT LIKE', '-3')
                        ->first();
                    if ($rowTmp) {
                        $row->apiID = $rowTmp->apiID;
                        $row->save();
                    }
                }
                $msg .= 'New Camp Size: ' . $row["size"] . '<br />';
                Burners::whereIn('campID', $merger1)
                    ->update([
                        'camp'        => $row->name,
                        'campID'      => $row->id,
                        'addyClock'   => $row->addyClock,
                        'addyLetter'  => $row->addyLetter,
                        'addyLetter2' => $row->addyLetter2,
                        'x'           => $row->x,
                        'y'           => $row->y
                    ]);
                $chk = BurnerCamps::whereIn('id', $merger1)
                    ->get();
                if ($chk->isNotEmpty()) {
                    foreach ($chk as $row2) $row->size += $row2->size;
                }
                BurnerCamps::where('id', $merger2[0])
                    ->update([ 'size' => $row->size ]);
                BurnerCamps::whereIn('id', $merger1)
                    ->delete();
                $msg .= '<script type="text/javascript"> setTimeout("window.location=\'#camp' . $merger2[0]
                    . '\'", 2000); </script>';
            }
        }
        $this->mainout .= view('vendor.burnermap.admin.merge-camps', [
            "msg"   => $msg,
            "camps" => BurnerCamps::orderBy('name', 'asc')->get()
            ])->render();
        return $this->printPage($request);
    }
    
    public function checkDeleted(Request $request)
    {
        $this->loadPage($request, 'admin');
        $msg = '';
        $start = (($request->has('start')) ? intVal($request->start) : 0);
        $perPage = 100;
        if ($request->has('del') && intVal($request->get('del')) > 0) {
            AllPastUsers::where('user', 'LIKE', $request->get('del'))
                ->delete();
        }
        $this->mainout .= view('vendor.burnermap.admin.check-deleted-accounts', [
            "msg"     => $msg,
            "start"   => $start,
            "perPage" => $perPage,
            "users"   => AllPastUsers::where('user', '>', 0)
                ->orderBy('user', 'asc')
                ->offset($start)
                ->limit($perPage)
                ->get()
            ])->render();
        return $this->printPage($request);
    }
    
    public function textSettings(Request $request)
    {
        $this->loadPage($request, 'admin');
        $msg = '';
        $y = intVal(date("Y"));
        $settingList = ['streetLet01Esplanade', 'streetLet20A', 'streetLet21B', 'streetLet22C', 'streetLet23D', 
            'streetLet24E', 'streetLet25F', 'streetLet26G', 'streetLet27H', 'streetLet28I', 'streetLet29J', 
            'streetLet30K', 'streetLet31L', 'streetLet32M', 'streetLet33N', 'streetLet40InnerCircle', 
            'streetLet41RodsRoad', 'streetLet42Portal', 'streetLet43Plaza', 'streetLet44DeepPlaza', 'streetLet46WalkIn', 
            'streetLet47Landing', 'date01EarlyStart', 'date02BurnStart', 'date03BurningEnd', 'date04LateLeave'];
        $settingVals = [];
        for ($j = $y; $j > 2010; $j--) $settingVals[$j] = [];
        $chk = TextSettings::get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $setting) $settingVals[$setting->year][$setting->type] = $setting->value;
        }
        if ($request->has('textSub')) {
            $yearEdit = intVal($request->get('year'));
            foreach ($settingList as $s) {
                $curr = TextSettings::where('type', $s)
                    ->where('year', $yearEdit)
                    ->first();
                if (!$curr) {
                    $curr = new TextSettings;
                    $curr->type = $s;
                    $curr->year = $yearEdit;
                }
                $curr->value = $request->get($s);
                $curr->save();
                if (strpos($s, 'streetLet') !== false && $request->get($s) != $settingVals[$y][$s]) {
                    Burners::where('addyLetter', 'LIKE', $settingVals[$y][$s])
                        ->update([ 'addyLetter' => $request->get($s) ]);
                    BurnerCamps::where('addyLetter', 'LIKE', $settingVals[$y][$s])
                        ->update([ 'addyLetter' => $request->get($s) ]);
                    BurnerVillages::where('addyLetter', 'LIKE', $settingVals[$y][$s])
                        ->update([ 'addyLetter' => $request->get($s) ]);
                    CoordConvert::where('addyLetter', 'LIKE', $settingVals[$y][$s])
                        ->update([ 'addyLetter' => $request->get($s) ]);
                }
                $settingVals[$y][$s] = $request->get($s);
            }
        }
        if ($request->has('resetStreets')) {
            foreach ($settingList as $s) {
                if (strpos($s, 'streetLet') !== false) {
                    $oldList = [];
                    for ($j = $y-1; $j > 2010; $j--) $oldList[] = $settingVals[$j][$s];
                    Burners::whereIn('addyLetter', $oldList)
                        ->update([ 'addyLetter' => $request->get($s) ]);
                    BurnerCamps::whereIn('addyLetter', $oldList)
                        ->update([ 'addyLetter' => $request->get($s) ]);
                    BurnerVillages::whereIn('addyLetter', $oldList)
                        ->update([ 'addyLetter' => $request->get($s) ]);
                    CoordConvert::whereIn('addyLetter', $oldList)
                        ->update([ 'addyLetter' => $request->get($s) ]);
                }
            }
            $msg .= 'All new streets forced to reset.';
        }
        $this->mainout .= view('vendor.burnermap.admin.text-settings', [
            "y"           => $y,
            "settingList" => $settingList,
            "settingVals" => $settingVals,
            "msg"         => $msg
            ])->render();
        return $this->printPage($request);
    }
    
    public function uploadMaps(Request $request)
    {
        $this->loadPage($request, 'admin');
        $msg = '';
        $filenameList = ['map.png', 'map-print.png', 'map-zoom.png', 
            'map-zoom1.png', 'map-zoom2.png', 'map-zoom3.png', 'map-zoom4.png'];
        if ($request->has('archiveMaps')) {
            foreach ($filenameList as $f) {
                $arch = str_replace('.png', '-' . (intVal(date("Y"))-1) . '.png', $f);
                if (!file_exists($arch)) {
                    File::copy('../public/images/maps/' . $f, '../public/images/maps/' . $arch);
                    $msg .= $f . ' Archived! ';
                }
            }
        }
        if ($request->has('upSub')) {
            foreach ($filenameList as $f) {
                $fld = str_replace('.png', '', str_replace('-', '', $f));
                if ($request->hasFile($fld)) {
                    $url = '../public/images/maps';
                    $request->file($fld)->storeAs('maps', $f);
                    if (file_exists($url . '/' . $f)) unlink($url . '/' . $f);
                    File::copy('../storage/app/maps/' . $f, $url . '/' . $f);
                    $msg .= 'Upload of ' . $f . ' Successful! ';
                }
            }
        }
        $this->mainout .= view('vendor.burnermap.admin.upload-maps', [ "msg" => $msg ])->render();
        return $this->printPage($request);
    }
    
    public function setKeypoints(Request $request)
    {
        $this->loadPage($request, 'admin');
        $this->map = new MapDeets;
        $msg = $jsLoad = $clcklst = '';
        $mapPoints = $mapIDs = [];
        $chk = Totals::where('type', 'LIKE', 'map-%')
            ->orderBy('type', 'asc')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $tot) $mapPoints[$tot->type] = $tot->value;
        }
        if ($request->has('adminSub')) {
            foreach ($mapPoints as $t => $v) {
                if ($mapPoints[$t] != $request->get($t)) {
                    $mapPoints[$t] = intVal($request->get($t));
                    Totals::where('type', 'LIKE', $t)
                        ->update([ 'value' => $mapPoints[$t] ]);
                    $msg .= 'Update ' . $t . ' to ' . $mapPoints[$t] . '. ';
                }
            }
        }
        foreach ($mapPoints as $t => $v) {
            if (strpos($t, 'map-') !== false) {
                $mapIDs[$t] = str_replace('map-', '', str_replace('-x', '', str_replace('-y', '', $t)));
                $jsLoad .= 'setTimeout("document.getElementById(\'' . $mapIDs[$t] . '\').style.' 
                    . ((strpos($t, '-x')) ? 'left=\'' . ($v-$this->map->pointOffX) : 'top=\'' 
                        . ($v-$this->map->pointOffY)) . 'px\'", 10); ' . "\n";
                if (strpos($t, '-x') > 0) {
                    $clcklst .= '<tr><td><a id="clickLab' . $mapIDs[$t] . '" class="clickLab" href="javascript:;" '
                        . 'onClick="return setCurrClick(\'' . $mapIDs[$t] . '\');">';
                    if ($mapIDs[$t] == '10esp') $clcklst .= '10 & Esplanade';
                    elseif ($mapIDs[$t] == '10w') $clcklst .= '10 & Walk-in';
                    elseif ($mapIDs[$t] == 'center') $clcklst .= 'Map Center (The Man)';
                    elseif ($mapIDs[$t] == 'rod-center') $clcklst .= 'Center of Center Camp';
                    elseif ($mapIDs[$t] == 'inner-12') $clcklst .= '12 & Inner Circle';
                    elseif ($mapIDs[$t] == 'rod-12') $clcklst .= '12 & Rod\'s Road';
                    else $clcklst .= '10 & ' . strtoupper(str_replace('10', '', $mapIDs[$t]));
                    $clcklst .= '</a></td>' . "\n" . '   <td><input type="text" name="' . $t . '" id="' . $t 
                        . 'ID" value="' . $v . '" style="width: 60px;" autocomplete="off"></td>' . "\n";
                } else {
                    $clcklst .= '   <td><input type="text" name="' . $t . '" id="' . $t . 'ID" value="' . $v 
                        . '" style="width: 60px;"></td></tr>' . "\n";
                }
            }
        }
        $this->mainout .= view('vendor.burnermap.admin.map-tool-streets', [
            "msg"       => $msg,
            "mapPoints" => $mapPoints,
            "mapIDs"    => $mapIDs,
            "myBurn"    => $this->myBurn,
            "jsLoad"    => $jsLoad,
            "clcklst"   => $clcklst,
            "pointOffX" => $this->map->pointOffX,
            "pointOffY" => $this->map->pointOffY
            ])->render();
        return $this->printPage($request);
    }
    
    public function setMiscPoints(Request $request)
    {
        $this->loadPage($request, 'admin');
        $this->vars = new BurnerVars;
        $this->map = new MapDeets;
        $msg = '';
        if ($request->has('adminSub')) {
            if ($request->get('addyLetter') == 'Landing Strip') {
                $this->storeCoordConvert($request->get('MouseX'), $request->get('MouseY'), $request->get('addyLetter'));
                echo 'Updated Landing Strip<br />to (' . $request->get('MouseX') . ', ' . $request->get('MouseY') . ')';
            }
            elseif ($request->get('addyClock') != '?:??' && $request->get('addyLetter') != '???') {
                $this->storeCoordConvert($request->get('MouseX'), $request->get('MouseY'), 
                    $request->get('addyLetter'), $request->get('addyClock'));
                echo 'Updated ' . $request->get('addyClock') . ' & ' . $request->get('addyLetter') . '<br />to (' 
                    . $request->get('MouseX') . ', ' . $request->get('MouseY') . ')';
            }
            exit;
        }
        $this->mainout .= view('vendor.burnermap.admin.map-tool-misc', [
            "msg"           => $msg,
            "streetClocks"  => $this->vars->streetClocks,
            "pointOffX"     => $this->map->pointOffX,
            "pointOffY"     => $this->map->pointOffY
            ])->render();
        return $this->printPage($request);
    }
    
    public function calcNewCoords(Request $request)
    {
        $this->loadPage($request, 'admin');
        $msg = '';
        if ($request->has('run')) {
            $this->vars = new BurnerVars;
            $mapPoints = [];
            $chk = Totals::where('type', 'LIKE', 'map-%')
                ->orderBy('type', 'asc')
                ->get();
            if ($chk->isNotEmpty()) {
                foreach ($chk as $tot) $mapPoints[$tot->type] = $tot->value;
            }
            CoordConvert::whereNotIn('addyLetter', ['Portal', 'Plaza', 'Deep Plaza', 'Landing Strip'])
                ->update([ 'x' => 0, 'y' => 0 ]);
            foreach ($this->vars->streetLetters as $s) {
                if (!in_array($s, ['???', 'Landing Strip', 'Portal', 'Plaza', 'Deep Plaza'])) {
                    $abbr = (($s == 'Esplanade') ? 'esp' : strtolower(substr($s, 0, 1)));
                    $msg .= '<br /><br /><b>NEXT STREET: ' . $s . ' (' . $abbr . ')</b><br /><br />';
                    if ($s == 'Rods Road') { // 10:00 angle from noon is 300 degrees
                        $msg .= '<br /><br /><i>calculating RODS</i> ' . $abbr . '...<br />';
                        $deltaY = $mapPoints['map-rod-center-y']-$mapPoints['map-rod-12-y']; // Adjacent
                        $deltaX = $mapPoints['map-rod-center-x']-$mapPoints['map-rod-12-x']; // Opposite
                        $streetRadius = abs(sqrt(($deltaX*$deltaX)+($deltaY*$deltaY))); // Hypotenuse
                        foreach ($this->vars->streetClocks as $c) {
                            if ($c != '?:??') {
                                $deg = $this->convertClock2Angle($c);
                                $newY = round($mapPoints['map-rod-center-y']-(cos(deg2rad($deg))*$streetRadius));
                                $newX = round($mapPoints['map-rod-center-x']+(sin(deg2rad($deg))*$streetRadius));
                                $this->storeCoordConvert($newX, $newY, $s, $c);
                                $msg .= '&nbsp;&nbsp;&nbsp;' . $c . ' & ' . $s . ' => (' . $newX . ', ' . $newY . ') ';
                            }
                        }
                    } elseif (in_array($s, ['Center Camp Plaza', 'Inner Circle'])) {
                        $msg .= '<br /><br /><i>calculating INNER</i> ' . $abbr . '...<br />'; 
                        $deltaY = $mapPoints['map-rod-center-y']-$mapPoints['map-inner-12-y']; // Adjacent
                        $deltaX = $mapPoints['map-rod-center-x']-$mapPoints['map-inner-12-x']; // Opposite
                        $streetRadius = abs(sqrt(($deltaX*$deltaX)+($deltaY*$deltaY))); // Hypotenuse
                        foreach ($this->vars->streetClocks as $c) {
                            if ($c != '?:??') {
                                $deg = $this->convertClock2Angle($c);
                                $newY = round($mapPoints['map-rod-center-y']-(cos(deg2rad($deg))*$streetRadius));
                                $newX = round($mapPoints['map-rod-center-x']+(sin(deg2rad($deg))*$streetRadius));
                                $this->storeCoordConvert($newX, $newY, $s, $c);
                                $msg .= '&nbsp;&nbsp;&nbsp;' . $c . ' & ' . $s . ' => (' . $newX . ', ' . $newY . ') ';
                            }
                        }
                    } elseif ($abbr != '' && $abbr != '?') {
                        $msg .= '<br /><br /><i>calculating street</i> ' . $abbr . '...<br />';
                        $deltaY = $mapPoints['map-center-y']-$mapPoints['map-10' . $abbr . '-y']; // Adjacent
                        $deltaX = $mapPoints['map-center-x']-$mapPoints['map-10' . $abbr . '-x']; // Opposite
                        $streetRadius = abs(sqrt(($deltaX*$deltaX)+($deltaY*$deltaY))); // Hypotenuse
                        foreach ($this->vars->streetClocks as $c) {
                            if ($c != '?:??') {
                                $deg = $this->convertClock2Angle($c);
                                $newY = round($mapPoints['map-center-y']-(cos(deg2rad($deg))*$streetRadius));
                                $newX = round($mapPoints['map-center-x']+(sin(deg2rad($deg))*$streetRadius));
                                $this->storeCoordConvert($newX, $newY, $s, $c);
                                $msg .= '&nbsp;&nbsp;&nbsp;' . $c . ' & ' . $s . ' => (' . $newX . ', ' . $newY . ') ';
                            }
                        }
                    }
                }
            }
        }
        $this->mainout .= view('vendor.burnermap.admin.calculate-new-coords', [ "msg" => $msg ])->render();
        return $this->printPage($request);
    }
    
    protected function storeCoordConvert($x, $y, $let, $clock = '')
    {
        $coord = CoordConvert::where('addyClock', 'LIKE', $clock)
            ->where('addyLetter', 'LIKE', $let)
            ->first();
        if (!$coord) {
            $coord = new CoordConvert;
            $coord->addyClock = $clock;
            $coord->addyLetter = $let;
        }
        $coord->x = $x;
        $coord->y = $y;
        $coord->save();
        return true;
    }
    
    protected function convertClock2Angle($clock)
    {
        $degrees = 0;
        list($hour, $min) = explode(':', $clock);
        $degrees += intVal($hour)*30;
        $degrees += intVal($min)/2;
        return $degrees;
    }

    public function reassignNewCoords(Request $request)
    {
        $this->loadPage($request, 'admin');
        $msg = '';
        if ($request->has('run')) {
            $run = intVal($request->get('run'));
            $tbl = intVal($request->get('tbl'));
            $tbls = ['Burners', 'BurnerCamps', 'BurnerVillages'];
            $msg = '<div class="adminSpacer">';
            if ($run == 1) {
                Burners::where('x', '>', 0)->update([ 'x' => 0, 'y' => 0 ]);
            } elseif ($run == 2) {
                BurnerCamps::where('x', '>', 0)->update([ 'x' => 0, 'y' => 0 ]);
            } elseif ($run == 3) {
                BurnerVillages::where('x', '>', 0)->update([ 'x' => 0, 'y' => 0 ]);
            } elseif ($tbl < sizeof($tbls)) {
                eval("\$chk = BurnerMap\\Models\\" . $tbls[$tbl] . "::select('id', 'x', 'y', 'addyClock', 'addyLetter')
                    ->where('addyClock', 'NOT LIKE', '?:??')
                    ->where('addyLetter', 'NOT LIKE', '???')
                    ->where('x', 0)
                    ->orderBy('id', 'asc')
                    ->limit(200)
                    ->get();");
                if ($chk->isNotEmpty()) {
                    foreach ($chk as $row) {
                        $rowCoord = CoordConvert::where('addyClock', 'LIKE', $row->addyClock)
                            ->where('addyLetter', 'LIKE', $row->addyLetter)
                            ->first();
                        if ($rowCoord) {
                            $ranOne = true;
                            $row->x = $rowCoord->x;
                            $row->y = $rowCoord->y;
                            $row->save();
                            $msg .= $tbls[$tbl] . ' #' . $row->getKey() . ' (' . $row->x . ', ' . $row->y . '), ';
                        } elseif ($row->addyLetter == 'Landing Strip') {
                            $rowCoord = CoordConvert::where('addyLetter', 'LIKE', 'Landing Strip')
                                ->first();
                            if ($rowCoord) {
                                $ranOne = true;
                                $row->x = $rowCoord->x;
                                $row->y = $rowCoord->y;
                                $row->save();
                                $msg .= $tbls[$tbl] . ' #' . $row->getKey() . ' (' . $row->x . ', ' . $row->y . '), ';
                            } else {
                                $msg .= 'failed finding ' . $tbls[$tbl] . ' #' . $row->getKey() . ' at ' 
                                    . $row->addyClock . ' & ' . $row->addyLetter . ', ';
                            }
                        } else {
                            $msg .= 'failed finding ' . $tbls[$tbl] . ' #' . $row->getKey() . ' at ' 
                                . $row->addyClock . ' & ' . $row->addyLetter . ', ';
                        }
                    }
                } else {
                    $tbl++;
                }
            }
            if ($tbl < sizeof($tbls)) {
                $msg .= '<script type="text/javascript"> setTimeout("window.location=\'?run=' . (1+$run) . '&tbl='
                    . $tbl . '\'", 2000);'
                    . ' </script> <center><h1 class="red"><i>...more loading...</i></h1></center><br /><br /></div>';
            } else {
                $msg .= '<center><h1>ALL DONE!</h1><a href="/admin">Back To Dashboard</a></center><br /><br /></div>';
            }
        }
        $this->mainout .= view('vendor.burnermap.admin.reassign-new-coords', [ "msg" => $msg ])->render();
        return $this->printPage($request);
    }

    public function showCurrCoords(Request $request)
    {
        $this->loadPage($request, 'admin');
        $this->map = new MapDeets;
        $plots = '';
        $specials = ['Esplanade', 'Center Camp Plaza', 'Inner Circle', 'Rods Road', 'Portal', 'Plaza', 'Deep Plaza', 
            'Landing Strip'];
        $chk = CoordConvert::where('x', '>', 0)
            ->where('y', '>', 0)
            ->where('x', '<', 700)
            ->where('y', '<', 550)
            ->whereNotIn('addyLetter', $specials)
            ->orderBy('addyLetter', 'asc')
            ->orderBy('addyClock', 'asc')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $coord) $plots .= $this->currCoordPlot($coord);
        }
        $chk = CoordConvert::where('x', '>', 0)
            ->where('y', '>', 0)
            ->where('x', '<', 700)
            ->where('y', '<', 550)
            ->whereIn('addyLetter', $specials)
            ->orderBy('addyLetter', 'asc')
            ->orderBy('addyClock', 'asc')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $coord) $plots .= $this->currCoordPlot($coord);
        }
        $this->mainout .= view('vendor.burnermap.admin.show-curr-coords', [ "plots" => $plots ])->render();
        return $this->printPage($request);
    }
    
    protected function currCoordPlot($coord)
    {
        return '<div class="absDiv" style="z-index: 90; top: ' . ($coord->y-$this->map->pointOffY) . 'px; left: '
            . ($coord->x-$this->map->pointOffX) . 'px; opacity:0.95; filter:alpha(opacity=95);">'
            . '<img src="/images/pointer-small.png" border=0 ></div>' . "\n";
    }
    
    
    
    // defaults to format for Laravel database seeder
    public function exportLaravelSeeder(Request $request)
    {
        $this->loadPage($request, 'admin');
        $chk = TextSettings::orderBy('year', 'desc')
            ->orderBy('type', 'asc')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $i => $setting) {
                $this->mainout .= "\t\tDB::table('TextSettings')->insert([\n"
                    . "\t\t\t'type'  => '" . $setting->type  . "',\n"
                    . "\t\t\t'year'  => "  . $setting->year  . ",\n"
                    . "\t\t\t'value' => '" . $setting->value . "'\n"
                    . "\t\t]);\n";
            }
        }
        $chk = Totals::orderBy('type', 'asc')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $i => $setting) {
                $this->mainout .= "\t\tDB::table('Totals')->insert([\n"
                    . "\t\t\t'type'  => '" . $setting->type  . "',\n"
                    . "\t\t\t'value' => " . $setting->value  . "\n"
                    . "\t\t]);\n";
            }
        }
        echo '<pre>' . $this->mainout . '</pre>';
        exit;
    }
    
    
}
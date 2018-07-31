<?php
namespace BurnerMap\Controllers;

use DB;
use Illuminate\Http\Request;

use BurnerMap\Models\Burners;
use BurnerMap\Models\BurnerCamps;
use BurnerMap\Models\BurnerVillages;
use BurnerMap\Models\CoordConvert;

class MapDeets
{
    public $fullPlot    = '';
    public $ajax        = '';
    
    public $campDeets   = [];
    public $villDeets   = [];
    public $cnt         = 0;
    public $resCnt      = 0;
    public $resCnt2     = 0;
    public $resCnt2b    = 0;
    public $resCnt2c    = 0;
    
    public $skips       = [];
    public $solos       = [];
    public $losts       = [];
    public $absents     = [];
    public $plots       = [];
    public $camps       = [];
    public $campGraph   = [];
    public $campOrd     = [];
    public $friendDone  = [];
    public $printNotes  = [];
    public $campsHalf   = -1;
    
    public $zeros       = [260, 580]; // x, y coordinates for unmappable locations
    public $pointOffX   = 9;
    public $pointOffY   = 25;
    public $labelOffX   = 55;
    public $labelOffY   = 120;
    public $campLabOffX = 12;
    public $campLabOffY = 100;
    public $zoomWidth   = 2796;
    public $zoomHeight  = 2196;
    
    public $specialTime = "'10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', "
        . "'12:15', '12:30', '12:45', '1:00', '1:15', '1:30', '1:45', '?:??'";
    
    function __construct()
    {
        return true;
    }

    public function loadCampDeets($archYear = '')
    {
        $this->campDeets = $this->villDeets = $chk = [];
        if ($archYear != '') eval("\$chk = BurnerMap\\Models\\BurnerCamps" . $archYear . "::get();");
        else {
            $chk = DB::table('BurnerCamps')
                ->leftJoin('OfficialCampsAPI', 'BurnerCamps.apiID', '=', 'OfficialCampsAPI.uid')
                ->select('BurnerCamps.*', 'OfficialCampsAPI.url', 'OfficialCampsAPI.description')
                ->get();
        }
        if ($chk->isNotEmpty()) {
            foreach ($chk as $camp) {
                $this->campDeets[$camp->id] = $camp;
                if ($archYear != '') $this->chkCampRecord($camp->id);
            }
        }
        $chk = BurnerVillages::orderBy('name', 'asc')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $village) $this->villDeets[$village->id] = $village;
        }
        return true;
    }
    
    public function getXY($x, $y, $zoom = false)
    {
        if ($x == 0 && $y == 0) {
            $x = $this->zeros[0];
            $y = $this->zeros[1];
            if ($this->zeros[0] < 670) $this->zeros[0] += 20;
            else $this->zeros = array(20, 25+$this->zeros[1]);
        } elseif ($zoom) {
            return $this->zoomXY($x, $y);
        }
        return [$x, $y];
    }
    
    public function zoomXY($x, $y)
    {
        return [(4*$x), (4*$y)];
    }
    
    public function addCamp($campID, $x, $y, $isPrint)
    {
        $this->cnt++;
        $vID = $this->campDeets[$campID]->villageID;
        $this->campOrd[] = $campID;
        $this->campGraph[$campID] = [$this->campDeets[$campID]->name, $this->cnt, $vID, ''];
        $this->camps[$campID] = view('vendor.burnermap.map-camp-info', [
            "cnt"     => $this->cnt,
            "camp"    => $this->campDeets[$campID],
            "vill"    => ((isset($this->campDeets[$campID]->villageID) 
                && intVal($this->campDeets[$campID]->villageID) > 0
                && isset($this->villDeets[$this->campDeets[$campID]->villageID]))
                ? $this->villDeets[$this->campDeets[$campID]->villageID] : null),
            "isPrint" => $isPrint
            ])->render();
        if (isset($this->campDeets[$campID]->description) && trim($this->campDeets[$campID]->description) != '') {
            $this->ajax .= '$(document).ready(function(){ $("#campInfoBtn' . $camp->id . '").click(function(){ '
                . '$("#campInfo' . $camp->id . '").slideToggle("slow"); }); });';
        }
        $this->plots[] = view('vendor.burnermap.map-camp-plot', [
            "cnt"        => $this->cnt,
            "x"          => $x,
            "y"          => $y,
            "pointOffX"  => $this->pointOffX,
            "pointOffY"  => $this->pointOffY
            ])->render();
        return true;
    }
    
    public function plotNonCamper($friend, $profPic = '', $x = -3, $y = -3)
    {
        if ($x < 0 || $y < 0) {
            $x = $friend->x;
            $y = $friend->y;
        }
        $this->plots[] = view('vendor.burnermap.map-noncamper-plot', [
            "cnt"       => $this->cnt,
            "x"         => $x,
            "y"         => $y,
            "pointOffX" => $this->pointOffX,
            "pointOffY" => $this->pointOffY,
            "friend"    => $friend,
            "profPic"   => $profPic
            ])->render();
        return true;
    }
    
    public function plotCampDeets($zoom = false)
    {
        foreach ($this->campDeets as $id => $camp) {
            if (isset($this->campGraph[$id]) && trim($this->campGraph[$id][3]) != '') {
                $x = $camp->x;
                $y = $camp->y;
                if ($zoom) list($x, $y) = $this->zoomXY($x, $y);
                $this->plots[] = view('vendor.burnermap.map-camp-plot-deets', [
                    "cnt"         => $this->cnt,
                    "x"           => $x,
                    "y"           => $y,
                    "campLabOffX" => $this->campLabOffX,
                    "campLabOffY" => $this->campLabOffY,
                    "graph"       => $this->campGraph[$id],
                    "camp"        => $camp,
                    "villDeets"   => $this->villDeets
                    ])->render();
            }
        }
        return true;
    }
	
	public function chkCampRecord($campID)
	{
	    if (isset($this->campDeets[$campID]) && $this->campDeets[$campID]) {
	        if (isset($this->campDeets[$campID]->addyClock) && $this->campDeets[$campID]->addyClock != '?:??' 
	            && isset($this->campDeets[$campID]->addyLetter) && $this->campDeets[$campID]->addyLetter != '???'
	            && (intVal($this->campDeets[$campID]->x) == 0 || intVal($this->campDeets[$campID]->y) == 0)) {
	            $chk = CoordConvert::where('addyClock', $this->campDeets[$campID]->addyClock)
	                ->where('addyLetter', $this->campDeets[$campID]->addyLetter)
	                ->first();
	            if ($chk) {
	                $this->campDeets[$campID]->x = $chk->x;
	                $this->campDeets[$campID]->y = $chk->y;
	                $campRow = BurnerCamps::find($campID);
	                if ($campRow) $campRow->update([ 'x' => $chk->x, 'y' => $chk->y ]);
	            }
	        }
	    }
	    return true;
	}
    
    public function chkCampSizes()
    {
        $sizes = [];
        $chk = Burners::where('campID', '>', 0)
            ->select('campID')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $u) {
                if (!isset($sizes[$u->campID])) $sizes[$u->campID] = 1;
                else $sizes[$u->campID]++;
            }
            foreach ($sizes as $campID => $size) BurnerCamps::find($campID)->update([ 'size' => $size ]);
        }
        return true;
	}
    
    public function plotAllCamps($isPrint = false, $isZoom = false)
    {
        if (sizeof($this->campDeets) > 0) {
            $intersections = [];
            foreach ($this->campDeets as $campID => $camp) {
                if (!isset($intersections[$camp->addyClock . $camp->addyLetter])) {
                    $x = $camp->x;
                    $y = $camp->y;
                    if ($isZoom) list($x, $y) = $this->zoomXY($x, $y);
                    $intersections[$camp->addyClock . $camp->addyLetter] = [
                        $camp->addyClock, $camp->addyLetter, $x, $y, 0, ''];
                }
                $intersections[$camp->addyClock . $camp->addyLetter][4]++;
                $intersections[$camp->addyClock . $camp->addyLetter][5] .= '<div>' . $camp->name . '</div>';
            }
            $this->cnt = 0;
            foreach ($intersections as $int) {
                if ($int[2] > 0 && $int[3] > 0) {
                    $this->cnt++;
                    $this->plots[] = view('vendor.burnermap.camp-list-plot', [
                        "cnt"         => $this->cnt,
                        "int"         => $int,
                        "pointOffX"   => $this->pointOffX,
                        "pointOffY"   => $this->pointOffY,
                        "campLabOffX" => 12,
                        "campLabOffY" => 100,
                        "isList"     => true
                        ])->render();
                }
            }
        }
        return true;
	}
    
    public function listAllCamps($listAll = 1)
    {
        $qrys = [];
        $qryBase = "\$resCamps = BurnerMap\\Models\\BurnerCamps::select('id')->where('size', '>', 0)";
        $qrySffx = "->orderBy('name', 'asc')->get();";
        if ($listAll == 1) {
            $qrys[] = "";
        } else { // sort by addy
            $qrys[] = "->whereNotIn('addyClock', [" . $this->specialTime . "])->orderBy('addyClock', 'asc')"
                . "->orderBy('addyLetter', 'asc')";
            $qrys[] = "->whereIn('addyClock', [" . $this->specialTime . "])->orderBy('addyClock', 'asc')"
                . "->orderBy('addyLetter', 'asc')";
        }
        foreach ($qrys as $q => $qry) {
            eval($qryBase . $qry . $qrySffx);
            if ($resCamps->isNotEmpty()) {
                foreach ($resCamps as $camp) $this->camps[] = $camp->id;
            }
        }
        return true;
	}
    
    public function excelAllCamps($listAll = 1)
    {
        $filename = 'FullCampList-by' . (($listAll == 1) ? 'Name' : 'Address') . '-' . date("Y-m-d") . '.xls';
        $innerTable = '<tr><td>Camp Name</td><td>Address: Clock</td><td>Address: Ring</td><td>Address: Ring Side</td>'
            . '<td>Address Single Line</td><td>City Postal Info</td><td>Full Postal Address</td>'
            . '<td>Burning Man API Camp ID</td></tr>';
        if (sizeof($this->camps) > 0) {
            foreach ($this->camps as $i => $camp) {
                $addy2 = ((trim($this->campDeets[$camp]->addyLetter2) != '' 
                    && $this->campDeets[$camp]->addyLetter2 != '???') ? $this->campDeets[$camp]->addyLetter2 : '');
                $addySingle = $this->campDeets[$camp]->addyClock . ' & ' . $this->campDeets[$camp]->addyLetter . $addy2;
                $innerTable .= '<tr><td>' . $this->campDeets[$camp]->name . '</td><td>' 
                    . $this->campDeets[$camp]->addyClock . '</td><td>' . $this->campDeets[$camp]->addyLetter 
                    . '</td><td>' . $addy2 . '</td><td>' . $addySingle . '</td><td>Gerlach, NV 89412</td><td>' 
                    . $this->campDeets[$camp]->name . ', ' . $addySingle . ', Gerlach, NV 89412</td><td>' 
                    . ((trim($this->campDeets[$camp]->apiID) != '' && trim($this->campDeets[$camp]->apiID) != '-3') 
                        ? $this->campDeets[$camp]->apiID : '') . '</td></tr>';
            }
        }
        return $GLOBALS["util"]->exportExcel($innerTable, $filename);
	}
    
    public function jsonAllCamps($year = 0)
    {
        header('Content-Type: application/json');
        if ($year == 0) {
            echo json_encode([ "year" => $year, "camps" => [], "error" => "sorry, no data" ]);
            exit;
        }
        $arr = [ "year" => $year, "camps" => [] ];
        eval("\$resCamps = BurnerMap\\Models\\BurnerCamps" . (($year > 2010 && $year < intVal(date("Y"))) ? $year : "")
            . "::orderBy('name', 'asc')->get();");
        if ($resCamps->isNotEmpty()) {
            foreach ($resCamps as $camp) {
                $arr["camps"][] = [
                    'name' 		=> utf8_encode($camp->name), 
                    'adClock' 	=> $camp->addyClock, 
                    'adRing' 	=> $camp->addyLetter, 
                    'adSide' 	=> ((trim($camp->addyLetter2) != '' && $camp->addyLetter2 != '???') 
                                    ? $camp->addyLetter2 : ''), 
                    'x' 		=> $camp->x, 
                    'y' 		=> $camp->y, 
                    'size'		=> $camp->size,
                    'id' 		=> $camp->id, 
                    'apiID' 	=> ((trim($camp->apiID) != '') ? $camp->apiID : '')
                    ];
            }
        }
        echo json_encode($arr);
        exit;
    }
    
}
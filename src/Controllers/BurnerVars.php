<?php
namespace BurnerMap\Controllers;

use BurnerMap\Models\BurnerCamps;
use BurnerMap\Models\BurnerVillages;
use BurnerMap\Models\TextSettings;

class BurnerVars
{
    public $streetClocks         = [];
    public $streetClocksReserved = [];
    public $streetLetters        = [];
    public $streetLetters2       = [];
    public $roundClocks          = [];
    public $villageList          = [];
    public $mainDates            = [];
    
    function __construct()
    {
        $this->streetClocks = ['?:??', 
            '12:00', '12:15', '12:30', '12:45', '1:00', '1:15', '1:30', '1:45', 
            '2:00', '2:05', '2:10', '2:15', '2:20', '2:25', '2:30', '2:35', '2:40', '2:45', '2:50', '2:55', 
            '3:00', '3:05', '3:10', '3:14', '3:15', '3:20', '3:25', '3:30', '3:35', '3:40', '3:45', '3:50', '3:55', 
            '4:00', '4:05', '4:10', '4:15', '4:20', '4:25', '4:30', '4:35', '4:40', '4:45', '4:50', '4:55', 
            '5:00', '5:05', '5:10', '5:15', '5:20', '5:25', '5:30', '5:35', '5:40', '5:45', '5:50', '5:55', 
            '6:00', '6:05', '6:10', '6:15', '6:20', '6:25', '6:30', '6:35', '6:40', '6:45', '6:50', '6:55', 
            '7:00', '7:05', '7:10', '7:15', '7:20', '7:25', '7:30', '7:35', '7:40', '7:45', '7:50', '7:55', 
            '8:00', '8:05', '8:10', '8:15', '8:20', '8:25', '8:30', '8:35', '8:40', '8:45', '8:50', '8:55', 
            '9:00', '9:05', '9:10', '9:15', '9:20', '9:25', '9:30', '9:35', '9:40', '9:45', '9:50', '9:55', 
            '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45'];
        $this->streetClocksReserved = ['12:00', '12:05', '12:10', '12:15', '12:20', '12:25', '12:30', 
            '12:35', '12:40', '12:45', '12:50', '12:55', '1:00', '1:05', '1:10', '1:15', '1:20', '1:25', '1:30', 
            '1:35', '1:40', '1:45', '1:50', '1:55', '10:05', '10:10', '10:15', '10:20', '10:25', '10:30', '10:35', 
            '10:40', '10:45', '10:50', '10:55', '11:00', '11:05', '11:10', '11:15', '11:20', '11:25', '11:30', 
            '11:35', '11:40', '11:45', '11:50', '11:55'];
        $this->streetLetters = ['???'];
        $chk = TextSettings::where('year', date("Y"))
            ->where('type', 'LIKE', 'streetLet%')
            ->orderBy('type', 'asc')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $row) $this->streetLetters[] = $row->value;
        }
        $this->streetLetters2 = ['Man-side', 'Mountain-side', 'Clock-side'];
        $chk = BurnerVillages::orderBy('name', 'asc')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $row) $this->villageList[$row->id] = $row;
        }
        $chk = TextSettings::where('year', date("Y"))
            ->where('type', 'LIKE', 'date%')
            ->orderBy('type', 'asc')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $row) $this->mainDates[] = $row->value;
        }
        $this->autoCorrectData();
        return true;
    }
    
    public function printDateOpts($preSel = '')
    {
        $ret = '<option value="">Select departure date</option><option DISABLED >'
            . '---EARLY ARRIVAL (requires Early Arrival pass)---</option>';
        $currStage = 'Early';
        $numSats = 0;
        $currDate = strtotime($this->mainDates[0]);
        while ($currDate <= strtotime($this->mainDates[3])) {
            $simpleDateFormat = date("n/j", $currDate);
            if (date("D", $currDate) == 'Sat') $numSats++;
            if ($currDate == strtotime($this->mainDates[1])) {
                $ret .= '<option DISABLED > </option><option DISABLED >---BURNING MAN WEEK---</option>';
                $currStage = '';
            }
            $ret .= '<option value="' . $simpleDateFormat . '" ' 
                . (($currStage == 'Early') ? 'style="color: #999;"' : '')
                . (($simpleDateFormat == $preSel) ? ' SELECTED ' : '') . '>' . date("D n/j", $currDate) 
                . (($numSats == 2 && date("D", $currDate) == 'Sat') ? ' (Man Burns!)' : '')
                . (($numSats == 2 && date("D", $currDate) == 'Sun') ? ' (Temple Burns!)' : '')
                . '</option>';
            if ($currDate == strtotime($this->mainDates[2])) {
                $ret .= '<option DISABLED > </option><option DISABLED >---LATE DEPARTURE---</option>';
                $currStage = 'Early';
            }
            $currDate = mktime(0, 0, 0, date("n", $currDate), date("j", $currDate)+1, date("Y", $currDate));
        }
        return $ret;
    }
    
    public function autoCorrectData()
    {
        /*
        $cacheAutoDat = false;
        $cacheChk = mysqli_query($GLOBALS["db"], "SELECT * FROM `cacheBlobs` WHERE `type` LIKE 'autoDataCorrect'");
        if ($cacheChk && mysqli_num_rows($cacheChk) > 0) {
            $cacheAutoDat = true;
            $cacheRow = mysqli_fetch_array($cacheChk);
            $expireTime = mktime(date("H"), date("i")-30, date("s"), date("n"), date("j"), date("Y"));
            //echo '<br />'. $cacheRow["date"] . ' < ? ' . date("Y-m-d H:i:s", $expireTime) . '<br />';
            if (strtotime($cacheRow["date"]) < $expireTime || $_GET["refresh"]) {
                $cacheChk = mysqli_query($GLOBALS["db"], "UPDATE `cacheBlobs` SET `date`=NOW() WHERE `type` LIKE 'autoDataCorrect'");
                $cacheAutoDat = false;
            }
        }
        else $res = mysqli_query($GLOBALS["db"], "INSERT INTO `cacheBlobs` VALUES (NULL, 'autoDataCorrect', NOW(), '', '', '', '')");
        
        if (!$cacheAutoDat || $_GET["refresh"]) {
            //$qman = "UPDATE `burnermap` SET `campID`='-1', `camp`='' WHERE (`camp` IS NULL OR `camp` LIKE '') AND `campID` > 0";
            //$res = mysqli_query($GLOBALS["db"], $qman);
            
            $qman = "DELETE FROM `burnerCamps` WHERE `name` IS NULL OR `name` LIKE ''";
            $res = mysqli_query($GLOBALS["db"], $qman);
            
            $campTots = array();
            $res = mysqli_query($GLOBALS["db"], "SELECT `campID` FROM `burnermap` WHERE `campID` > '0'");
            if ($res && mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    if (!isset($campTots[$row["campID"]])) $campTots[$row["campID"]] = 1;
                    else $campTots[$row["campID"]]++;
                }
            }
            foreach ($campTots as $id => $tot) {
                $res = mysqli_query($GLOBALS["db"], "UPDATE `burnerCamps` SET `size`='$tot' WHERE `id` LIKE '$id'");
            }
            
            // Hiding this for now until after gates are open in 2013
            //$qman = "DELETE FROM `burnerCamps` WHERE `size` LIKE '0'";
            //$res = mysqli_query($GLOBALS["db"], $qman);
                
            $res = mysqli_query($GLOBALS["db"], "OPTIMIZE TABLE `cacheBlobs`");
        }
        
        
        if (!isset($_SESSION["checkMyTickets"]) || $_SESSION["checkMyTickets"] < mktime(date("H")-1, date("i"), date("s"), date("m"), date("d"), date("Y"))) {
            $qman = "SELECT `user`, `ticketNeeds`, `ticketHas` FROM `burnermap` WHERE `user` IN (" . substr($friendStr, 2) . ") AND (`ticketHas` > '0' OR `ticketNeeds` > '0')";
            //echo $qman . '<br /><br />';
            $res2 = mysqli_query($GLOBALS["db"], $qman);
            if ($res2 && mysqli_num_rows($res2) > 0) {
                $myFriendTot = array(0, 0);
                while ($row2 = mysqli_fetch_array($res2)) {
                    $myFriendTot[0] += $row2["ticketHas"];
                    $myFriendTot[1] += $row2["ticketNeeds"];
                }
                $qman = "UPDATE `burnermap` SET `ticketFriend`='" . $myFriendTot[0] . "', `ticketFriendNeeds`='" . $myFriendTot[1] . "', `lastTicketCheck`=NOW() WHERE `user` LIKE '" . $user . "'";
                //echo $qman . '<br /><br />';
                $resUp = mysqli_query($GLOBALS["db"], $qman);
            }
            $_SESSION["checkMyTickets"] = time();
        }
        */
        
    }
    
    public function lnkFbRemind()
    {
        return 'https://www.facebook.com/dialog/apprequests?app_id=' . env('FB_CLIENT_ID') . '&redirect_uri=' 
            . urlencode('https://apps.facebook.com/burnermap/') . '&message=Where are YOU camping at Burning Man? '
            . 'Add your camp to my map so I can find you! And get your own printable friend map. https://BurnerMap.com';
    }
    
    public function lnkFbShare()
    {
        return 'https://www.facebook.com/sharer.php?s=100&p[title]=BurnerMap: Find Your Pals on the Playa&p[summary]='
            . 'I just created a map of my friends\' locations at Burning Man! Add yourself to my map and get your own, '
            . 'which you can print and take to the playa!&p[url]=https://burnermap.com&p[images][0]='
            . 'https://BurnerMap.com/images/logo2.png';
    }
    
    public function refreshBtn($url)
    {
        return '<a href="' . $url . '&refresh=1"><img src="/images/arrow_refresh.png" border=0 alt="Something '
            . 'funky with your map and/or list, this refresh button overrides your cache and is worth a try." '
            . 'title="Something funky with your map and/or list, this refresh button overrides your cache '
            . 'and is worth a try." ></a>';
    }
    
}
<?php
namespace BurnerMap\Controllers;

use Illuminate\Http\Request;

class IncUtils
{
    public $sessMsg = '';
    
    public function printSessMsg()
    {
        $tmp = '';
        if (trim($this->sessMsg) != '') $tmp .= '<div>' . $this->sessMsg . '</div>';
        if (session()->has('sessMsg')) {
            $tmp .= '<div>' . session()->get('sessMsg') . '</div>';
            session()->forget('sessMsg');
        }
        return $tmp;
    }
    
    public function prepExplode($delim, $str)
    {
        if (substr($str, 0, 1) == $delim) $str = substr($str, 1);
        if (substr($str, strlen($str)-1) == $delim) $str = substr($str, 0, strlen($str)-1);
        return $str;
    }
    
    public function mexplode($delim, $str)
    {
        $retArr = [];
        if (strpos($str, $delim) === false) {
            $retArr[0] = $str;
        } else {
            $str = $this->prepExplode($delim, $str);
            $retArr = explode($delim, $str);
        }
        return $retArr;
    }
    
    public function trimPlode($delim, $str)
    {
        $ret = '';
        $arr = $this->mexplode($delim, $str);
        if (sizeof($arr) > 0) {
            foreach ($arr as $s) {
                if (trim($s) != '') $ret .= (($ret != '') ? $delim : '') . $s;
            }
        }
        return $ret;
    }
    
    public function printNotes($strIn)
    {
        return str_replace('[[[heart]]]', ' <img src="/images/heart9.png" border=0 alt="&lt;3" title="&lt;3" > ', 
            $strIn);
    }
    
    public function prntFrmtName($friend, $lenMax = 44)
    {
        return $this->formatPlayaName($this->prntName($friend), $lenMax);
    }
    
    public function prntName($friend)
    {
        if (isset($friend->name) && trim($friend->name) != '') {
            if (!isset($friend->playaName) || trim($friend->playaName) == '') return $friend->name;
            else return $friend->playaName . ' (' . $friend->name . ')';
        }
        return '';
    }
        
    public function formatPlayaName($name, $lenMax = 44)
    {
        if (strpos(trim($name), ' ') === false && strlen($name) > $lenMax) {
            return $this->formatPlayaWord($name, $lenMax);
        }
        $nameOut = '';
        $words = $this->mexplode(' ', $name);
        if (sizeof($words) > 0) {
            foreach ($words as $w) $nameOut .= ' ' . $this->formatPlayaWord($w, $lenMax);
        }
        $nameOut = str_replace('  ', ' ', $nameOut);
        return trim($nameOut);
    }

    public function formatPlayaWord($name, $lenMax = 44)
    {
        $ret = '';
        while (strlen($name) > $lenMax) {
            $ret .= '<span class="mLn5"> </span>' . substr($name, 0, $lenMax);
            $name = substr($name, $lenMax);
        }
        if ($ret == '') return $name;
        $ret = trim($ret . '<span class="mLn5"> </span>' . $name);
        if (strpos($ret, '<span class="mLn5"> </span>') == 0) {
            $ret = substr($ret, strlen('<span class="mLn5"> </span>'));
        }
        return $ret;
    }

    public function chkReqOpts(Request $request, $currOpts, $fld = '', $opt = 1)
    {
        if ($fld == '' || $opt <= 1) return $currOpts;
        if ($request->has($fld) && intVal($request->get($fld)) > 0) {
            if ($currOpts%3 > 0) $currOpts = $currOpts*3;
        } elseif ($currOpts%3 == 0) {
            $currOpts = $currOpts/3;
        }
        return $currOpts;
    }
    
    public function exportExcel($innerTable, $inFilename = "export.xls")
    {
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' .$inFilename );
        echo '<table border=1>' . $innerTable . '</table>';
        exit;
    }
    
    public function jsRedirect($url = '')
    {
        echo '<html><body><script type="text/javascript"> setTimeout("window.location=\'' . $url . '\'", 10); '
            . '</script></body></html>';
        exit;
    }

}
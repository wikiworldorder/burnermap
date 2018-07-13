<!-- resources/views/vendor/burnermap/admin/map-tool-streets.blade.php -->
<center><div class="adminMenu adminMenuPage" style="width: 1000px;">
<div class="adminHeader">Set Map Grid Keypoints</div>
@if (trim($msg) != '') <center><h3 class="red">{!! $msg !!}</h3></center> @endif

<table border=0 cellpadding=0 cellspacing=0 ><tr><td class="vaT">

    <div class="adminSpacer taC">
        FIRST, click the center of the <span style="color: #00FF00;">green dot</span> to sync your mouse in the screen.
        <br />If it's gone, reload the page to start over.<br />
        Then click a label below, followed by clicking it's correct location on the map.<br />
        Change all locations needed, then hit the save button at the bottom.
    </div>
    <div class="relDiv" style="height: 549px; width: 699px; border: 1px #333 dotted;">
        <div class="absDiv" style="z-index: 1; top: 0px; left: 0px;"><img src="/images/maps/map.png" border=0 ></div>
        <div class="absDiv" id="syncDot" style="z-index: 99; top: 20px; left: 20px; background: #00FF00; 
            height: 10px; width: 10px; -moz-border-radius: 5px; border-radius: 5px;">
            <img src="/images/spacer.gif" border=0 style="height: 10px; width: 10px;" >
        </div>
        @foreach ($mapPoints as $t => $v)
            @if (strpos($t, 'map-') !== false && strpos($t, '-x') > 0)
                <div class="absDiv" id="{{ $mapIDs[$t] }}" style="z-index: 99; top: 0px; left: 0px;">
                    <img src="/images/pointer-small.png" border=0 >
                </div>
            @endif
        @endforeach
    </div>
    
    <center><img src="/images/keypointsSample.png" border=0 width=420 ></center>
    
</td><td class="vaT" width=400 >

    <form name="Show" action="?adminSub=1" method="post">
    <input type="hidden" id="csrfTok" name="_token" value="{{ csrf_token() }}">
    <table border=0 >
    <tr><th>Street</th><th>X</th><th>Y</th></tr>
    {!! $clcklst !!}
    </table>
    <input type="submit" value="Save All Coords" style="width: 100%; height: 40px; font-size: 14pt;">
    </form>
    
</td><tr></table>

</div></center>

<script type="text/javascript">
{!! $jsLoad !!}
var IE = document.all?true:false;
if (!IE) document.captureEvents(Event.MOUSEDOWN);
document.onmousedown = getMouseXY;
var tempX = 0;
var tempY = 0;
var syncX = 0;
var syncY = 0;
var currClickin = '';
function setCurrClick(newType) {
	currClickin = newType;
	document.getElementById('clickLab'+currClickin+'').style.background='#CCF';
	return true;
}
function getMouseXY(e) {
    if (IE) { // grab the x-y pos.s if browser is IE
        tempX = event.clientX + document.body.scrollLeft;
        tempY = event.clientY + document.body.scrollTop;
    } else {  // grab the x-y pos.s if browser is NS
        tempX = e.pageX;
        tempY = e.pageY;
    }  
    if (tempX < 0) tempX = 0;
    if (tempY < 0) tempY = 0;  
    if (syncX == 0 || syncY == 0) {
        syncX = tempX-25;
        syncY = tempY-25;
        document.getElementById('syncDot').style.display='none';
    } else {
        tempX = tempX-syncX;
        tempY = tempY-syncY;
        newPosX = tempX-{{ $pointOffX }};
        newPosY = tempY-{{ $pointOffY }};
        //document.Show.submit();
        if (currClickin != '' && tempX > 0 && tempX < 700 && tempY > 0 && tempY < 570) {
            document.getElementById('map-'+currClickin+'-xID').value=tempX;
            document.getElementById('map-'+currClickin+'-yID').value=tempY;
            document.getElementById(currClickin).style.left = ''+newPosX+'px';
            document.getElementById(currClickin).style.top = ''+newPosY+'px';
            document.getElementById('clickLab'+currClickin+'').style.background='#fff';
            currClickin = '';
        }
    }
    return true;
}
</script>
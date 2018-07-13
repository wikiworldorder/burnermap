<!-- resources/views/vendor/burnermap/admin/map-tool-misc.blade.php -->
<center><div class="adminMenu adminMenuPage" style="width: 1000px;">
<div class="adminHeader">Set Map Grid Keypoints</div>
@if (trim($msg) != '') <center><h3 class="red">{!! $msg !!}</h3></center> @endif

<table border=0 cellpadding=0 cellspacing=0 ><tr><td class="vaT">

    <div class="adminSpacer taC">
        FIRST, click the center of the <span style="color: #00FF00;">green dot</span> to sync your mouse in the screen.
        <br />If it's gone, reload the page to start over.
    </div>
    <div class="relDiv" style="height: 549px; width: 699px; border: 1px #333 dotted;">
        <div class="absDiv" style="z-index: 1; top: 0px; left: 0px;"><img src="/images/maps/map.png" border=0 ></div>
        <div class="absDiv" id="syncDot" style="z-index: 99; top: 20px; left: 20px; background: #00FF00; 
            height: 10px; width: 10px; -moz-border-radius: 5px; border-radius: 5px;">
            <img src="/images/spacer.gif" border=0 style="height: 10px; width: 10px;" >
        </div>
        <div class="absDiv" id="pointDiv" style="position: absolute; z-index: 99; top: 0px; left: 0px;">
            <img src="/images/pointer-small.png" border=0 >
        </div>
    </div>
    
</td><td class="vaT" width=400 >

    <div class="adminSpacer taC">
        For the few coordinates not automated. Select location, then click it on the map. <br />
        This will save your change upon clicking. Landing strip only gets one coordinate.
    </div>
    <div class="adminSpacer taC">
    <form name="Show" action="?adminSub=1" method="post" target="saveFrame">
    <input type="hidden" id="csrfTok" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="clickType" value="coords">
    Coordinates to Update:<br />
    <select id="addyClockID" name="addyClock" style="width: 70px;" >
    @foreach ($streetClocks as $i => $s)
        <option value="{{ $s }}" @if (($i > 0 && $i < 5) || $i > 101) style="color: #007397;" @endif >{{ $s }}</option>
    @endforeach
    </select> & 
    <select id="addyLetterID" name="addyLetter" style="width: 135px;" >
        <option value="???" >???</option>
        <option value="Portal" >Portal</option>
        <option value="Plaza" >Plaza</option>
        <option value="Deep Plaza" >Deep Plaza</option>
        <option value="Landing Strip" SELECTED >Landing Strip</option>
    </select><br /><br />
    (<input type="text" name="MouseX" value="0" size="4">,
    <input type="text" name="MouseY" value="0" size="4">)<br /><br />
    <iframe name="saveFrame" src="" width=100% height=100 frameborder=0 ></iframe>
    </form>
    </div>
    
</td><tr></table>

</div></center>

<script type="text/javascript">
var IE = document.all?true:false;
if (!IE) document.captureEvents(Event.MOUSEDOWN);
document.onmousedown = getMouseXY;
var tempX = 0;
var tempY = 0;
var syncX = 0;
var syncY = 0;
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
        if (tempX > 0 && tempX < 700 && tempY > 0 && tempY < 570) {
            document.Show.MouseX.value = tempX;
            document.Show.MouseY.value = tempY;
            newPosX = tempX-{{ $pointOffX }};
            newPosY = tempY-{{ $pointOffY }};
            document.getElementById('pointDiv').style.top = ''+newPosY+'px'; 
            document.getElementById('pointDiv').style.left = ''+newPosX+'px'; 
            document.Show.submit();
        }
    }
    return true;
}
</script>
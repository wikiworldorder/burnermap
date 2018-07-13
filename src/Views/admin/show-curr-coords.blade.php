<!-- resources/views/vendor/burnermap/admin/show-curr-coords.blade.php -->
<center><div class="adminMenu adminMenuPage">
<div class="adminHeader">Currently Stored Coordinate Translations</div>

<div class="relDiv" style="height: 549px; width: 699px; border: 1px #333 dotted;">
    <div id="mapLayer" class="absDiv" style="z-index: 1; top: 0px; left: 0px; 
        opacity:0.70; filter:alpha(opacity=70);"><img src="/images/maps/map.png" border=0 >
    </div>
    {!! $plots !!}
</div>
    
</div></center>

<script type="text/javascript">
function flipMap(onoff) {
	if (onoff == 0) {
		onoff = 1;
		document.getElementById('mapLayer').style.zIndex='95';
	} else {
		onoff = 0;
		document.getElementById('mapLayer').style.zIndex='1';
	}
	setTimeout("flipMap("+onoff+")", 3000);
	return true;
}
setTimeout("flipMap(0)", 3000);
</script>
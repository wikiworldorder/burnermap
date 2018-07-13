<!-- resources/views/vendor/burnermap/admin/upload-maps.blade.php -->
<center><div class="adminMenu adminMenuPageWide">
<div class="adminHeader">Upload Map Graphics for the New Year</div>
@if (trim($msg) != '') <center><h3 class="red">{!! $msg !!}</h3></center> @endif

<div class="adminSpacer taC">
    First, <a href="?archiveMaps=1">Archive Last Year's Map Graphics</a><br />
    <span class="f8">(Run This Process Once Per Year, After Jan and Before Uploading New Year's Maps)</span>
</div>
<br /><br />

<table border=0 class="smlFont" ><tr>
<form name="uploadMaps" action="?uploadMaps=1&upSub=1" method="post" enctype="multipart/form-data">
<input type="hidden" id="csrfTok" name="_token" value="{{ csrf_token() }}">
<td rowspan=2 >
	Upload Main Map (699 x 549): <input type="file" name="map" ><br />
	<a href="/images/maps/map.png" target="_blank"><img src="/images/maps/map.png" border=0 width=400 ></a>
	<center><br /><br /><input type="submit" value="Upload Map(s)" style="padding: 10px; font-size: 14pt;" ><br />
	for best results, upload one image at a time</center>
</td><td>
	Upload Print Map (699 x 549): <input type="file" name="mapprint" ><br />
	<a href="/images/maps/map-print.png" target="_blank"><img src="/images/maps/map-print.png" border=0 width=200 ></a>
</td><td>
	Upload Zoom Quarter Map, Top-Left (1398 x 1098): <input type="file" name="mapzoom1" ><br />
	<a href="/images/maps/map-zoom1.png" target="_blank"><img src="/images/maps/map-zoom1.png" border=0 width=200 ></a>
</td><td>
	Upload Zoom Quarter Map, Top-Right (1398 x 1098): <input type="file" name="mapzoom2" ><br />
	<a href="/images/maps/map-zoom2.png" target="_blank"><img src="/images/maps/map-zoom2.png" border=0 width=200 ></a>
</td></tr><tr><td>
	Upload Zoom Full Map (2796 x 2196): <input type="file" name="mapzoom" ><br />
	<a href="/images/maps/map-zoom.png" target="_blank"><img src="/images/maps/map-zoom.png" border=0 width=200 ></a>
</td><td>
	Upload Zoom Quarter Map, Bottom-Left (1398 x 1098): <input type="file" name="mapzoom3" ><br />
	<a href="/images/maps/map-zoom3.png" target="_blank"><img src="/images/maps/map-zoom3.png" border=0 width=200 ></a>
</td><td>
	Upload Zoom Quarter Map, Bottom-Right (1398 x 1098): <input type="file" name="mapzoom4" ><br />
	<a href="/images/maps/map-zoom4.png" target="_blank"><img src="/images/maps/map-zoom4.png" border=0 width=200 ></a>
</td></tr>
</form>

@for ($y = intVal(date("Y"))-1; $y > 2010; $y--)
	<tr><td colspan=4 ><br /><br /><br /><div class="adminHeader">Archive of {{ $y }} Maps</div></td></tr>
	<tr><td rowspan=2 >
		Main Map:<br />
		<a href="/images/maps/map-{{ $y }}.png" target="_blank"
		    ><img src="/images/maps/map-{{ $y }}.png" border=0 width=400 ></a>
	</td><td>
		Print Map:<br />
		<a href="/images/maps/map-print-{{ $y }}.png" target="_blank"
		    ><img src="/images/maps/map-print-{{ $y }}.png" border=0 width=200 ></a>
	</td><td>
		Zoom Quarter Map, Top-Left:<br />
		<a href="/images/maps/map-zoom1-{{ $y }}.png" target="_blank"
		    ><img src="/images/maps/map-zoom1-{{ $y }}.png" border=0 width=200 ></a>
	</td><td>
		Zoom Quarter Map, Top-Right:<br />
		<a href="/images/maps/map-zoom2-{{ $y }}.png" target="_blank"
		    ><img src="/images/maps/map-zoom2-{{ $y }}.png" border=0 width=200 ></a>
	</td></tr><tr><td>
		Zoom Full Map:<br />
		<a href="/images/maps/map-zoom-{{ $y }}.png" target="_blank"
		    ><img src="/images/maps/map-zoom-{{ $y }}.png" border=0 width=200 ></a>
	</td><td>
		Zoom Quarter Map, Bottom-Left:<br />
		<a href="/images/maps/map-zoom3-{{ $y }}.png" target="_blank"
		    ><img src="/images/maps/map-zoom3-{{ $y }}.png" border=0 width=200 ></a>
	</td><td>
		Zoom Quarter Map, Bottom-Right:<br />
		<a href="/images/maps/map-zoom4-{{ $y }}.png" target="_blank"
		    ><img src="/images/maps/map-zoom4-{{ $y }}.png" border=0 width=200 ></a>
	</td></tr>
@endfor
</table>
<br /><br /><br />
    
</div></center>
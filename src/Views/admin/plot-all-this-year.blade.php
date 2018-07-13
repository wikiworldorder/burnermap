<!-- resources/views/vendor/burnermap/admin/plot-all-this-year.blade.php -->
<div class="relDiv" style="height: 549px; width: 699px;">
	<div id="mapLayer" class="absDiv" style="z-index: 1; top: 0px; left: 0px;">
	    <img src="/images/maps/map.png" border=0 >
	</div>
    @if ($users->isNotEmpty())
        @foreach ($users as $usr)
            <div class="absDiv" style="z-index: 90; top: {{ ($usr->y-$pointOffY) }}px; 
                left: {{ ($usr->x-$pointOffX) }}px; opacity:0.95; filter:alpha(opacity=95);">
                <img src="/images/pointer-small.png" border=0 >
            </div>
        @endforeach
    @endif
</div>
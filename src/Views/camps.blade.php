<!-- resources/views/vendor/burnermap/camps.blade.php -->
@if ($isPrint)
<div class="wBrn">
@else 
<center><div class="wBrn taL">

<table width=699 height=26 border=0 cellpadding=0 cellspacing=0 style="border-collapse: collapse;"><tr>		
<td class="mapTabs"><nobr><a href="/map">My Friends</a></nobr></td>
<td class="mapTabsOn"><nobr><a href="?listAll=1">All Camps</a></nobr></td>
<td><a href="?listAll={{ $listAll }}&print=1" target="_blank" style="text-decoration: none;"
    ><img src="/images/maps/mapPrint.png" border=0 align=left hspace=20 ></a></td>
<td><a href="?listAll={{ $listAll }}&excel=1" target="_blank" style="text-decoration: none;"
    ><img src="/images/page_excel.png" border=0 align=left >Mailing List</a></td>

<td class="print20" style="text-align: right; padding: 0px; font-size: 9pt; color: #ff908f;">
    Camp info is public but<br />users' info is anonymous.</nobr></td>
</tr></table>

<div class="relDiv w100" style="background: #FFF; border: 1px #938252 solid; padding: 5px; margin-top: -1px;">
@endif

@if ($isZoom) 
    <div class="relDiv w100 print9">
        <div class="absDiv print10"><a href="javascript:;" onmouseover="clearMapDeets();"
            ><img src="/images/maps/map-zoom1.png" border=0 ></a></div>
        <div class="absDiv print11"><a href="javascript:;" onmouseover="clearMapDeets();">
            <img src="/images/maps/map-zoom2.png" border=0 ></a></div>
        <div class="absDiv print12"><a href="javascript:;" onmouseover="clearMapDeets();">
            <img src="/images/maps/map-zoom3.png" border=0 ></a></div>
        <div class="absDiv print13"><a href="javascript:;" onmouseover="clearMapDeets();">
            <img src="/images/maps/map-zoom4.png" border=0 ></a></div>
@else 
    <div class="relDiv w100 print7">
        <div class="absDiv print8">
        @if ($isPrint) <a href="javascript:void(0)"><img src="/images/maps/map-print.png"></a>
        @else <a href="javascript:;" onmouseover="clearMapDeets();"><img src="/images/maps/map.png"></a>
        @endif
        </div>
@endif
        <div class="absDiv print15" style="z-index: 1; top: 564px; left: 0px;">
            <a href="javascript:;" onmouseover="clearMapDeets();"
                ><img src="/images/spacer.gif" border=0 height={{ ($map->zeros[1]-570) }} width=699 ></a>
        </div>
        @forelse ($map->plots as $plot) {!! $plot !!} @empty @endforelse
    </div>

    <table border=0 class="anonMapList" >
		<tr><td class="print17" colspan=2 >
		@if ($listAll == 1)
            <b>All Camps Sorted By Name</b><br />
            @if (!$isPrint) <nobr><a href="?listAll=2" style="font-size: 10pt;">Sort By Address</a></nobr><br />
            @else BurnerMap.com @endif
        @else
            <b>All Camps Sorted By Address</b><br />
            @if (!$isPrint) <nobr><a href="?listAll=1" style="font-size: 10pt;">Sort By Camp Name</a></nobr><br />
            @else BurnerMap.com @endif
        @endif
		</td></tr><tr><td class="print18">
		@forelse ($map->camps as $i => $camp)
		    {{ $map->campDeets[$camp]->name }} <span>- 
		    {{ $map->campDeets[$camp]->addyClock }} & {{ $map->campDeets[$camp]->addyLetter }}
		    @if (trim($map->campDeets[$camp]->addyLetter2) != '' 
		        && $map->campDeets[$camp]->addyLetter2 != '???') 
		        ({{ $map->campDeets[$camp]->addyLetter2 }})
		    @endif </span><br />
			@if (($i+1) == ceil(sizeof($map->campDeets)/2)) </td><td class="print18"> @endif
        @empty
        @endforelse
    </table>
    
@if ($isPrint)
</div>
@else
</div></div>

<a name="json"></a><br /><br />
<a href="javascript:;" id="showJson" style="color: #999;"><i>Export Camp List to JSON</i></a>
<div id="jsonDeets" class="hid" style="width: 50%; padding-top: 20px;">
	<a href="/json?camps=1" target="_blank" style="font-size: 18px;"
		><u>burnermap.com/json.php?camps=1</u></a>
	<ul class="taL">
		<li><b>name</b> - Camp Name</li>
		<li><b>adClock</b> - Address: Clock Street</li>
		<li><b>adRing</b> - Address: Ring Street</li>
		<li><b>adSide</b> - Address: Ring Side</li>
		<li><b>x</b> - X-coordinate as plotted on BurnerMap</li>
		<li><b>y</b> - Y-coordinate as plotted on BurnerMap</li>
		<li><b>size</b> - Number of campers on BurnerMap</li>
		<li><b>id</b> - Unique Camp ID internal to BurnerMap</li>
		<li><b>apiID</b> - Unique Camp ID from the 
		    <a href="https://api.burningman.org/api/docs/v1" target="_blank">BMorg API</a>, if exists</li>
	</ul>
</div>
</center>
<br /><br />
@endif
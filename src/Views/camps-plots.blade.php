<!-- camps-plots.blade.php -->
@if (!$isPrint)
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
    
@if (!$isPrint)
</div></div></center>

@endif
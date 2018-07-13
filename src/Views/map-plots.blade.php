<!-- map-plots.blade.php -->
@if (!$isPrint)
<center><div class="wBrn taL">

<div class="condensed print3 w100 m0 p0 taC"><nobr>
    @if ($archYear == '')
        {!! $totsLabels !!} have shared their camp info <i>this year</i>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="#notYets" class="blackLnk">{{ number_format($myInfo->allPastFrndTot) }} friends</a>
        have mapped here before.
    @else {!! $totsLabels !!} shared their camp info in {{ $archYear }}.
    @endif <br />
    
    Please <a href="{!! $vars->lnkFbRemind() !!}" target="_blank" class="condensed">remind specific friends</a> and 
    <a title="Share on Facebook" href="{!! $vars->lnkFbShare() !!}" target="_blank" class="condensed">share on your 
    newsfeed.</a>
</nobr></div>
    
<div class="relDiv">
    @if ($request->has('zoom')) <div class="absDiv print4"><a href="/map/?list=1"><img src="/images/zoom_out.png" 
        border=0 ></a>&nbsp;{!! $vars->refreshBtn($currUrl) !!}</div>
    @else <div class="absDiv print5"><a href="/map/?list=1&zoom=1"><img src="/images/zoom_in.png" border=0 ></a>
        &nbsp;{!! $vars->refreshBtn($currUrl) !!}</div>
    @endif
    <table height=26 border=0 cellpadding=0 cellspacing=0 class="w100" style="border-collapse:collapse" ><tr>
    <td id="friendsTab" class=" @if ($request->has('printForm')) mapTabs @else mapTabsOn @endif ">
        <nobr><a href="/map/">My Friends</a></nobr></td>
    <td id="allTab" class="mapTabs"><nobr><a href="?listAll=1">All Camps</a></nobr></td>
    <td><a href="/map/?print=1" target="_blank" style="text-decoration: none;">
        <img src="/images/maps/mapPrint.png" border=0 align=left hspace=20 ></a></td>
    <td><a href="/map/?excel=1" target="_blank" class="f11" style="text-decoration: none;"><nobr>
        <img src="/images/page_excel.png" border=0 align=left >Mailing List</nobr></a></td>
    <td class="mapTabsScroll"><div class="relDiv"><div class="absDiv" style="text-align: right;">
        <nobr><a href="/disclaimers.php" target="_blank">Map disclaimers from Burning Man</a></nobr>
        <br /><nobr><i>Map Archives:</i>&nbsp;&nbsp;
        <select name="chooseArchive" onChange="window.location='?arch='+this.value+'';">
            <option value="{{ date('Y') }}" SELECTED >{{ date("Y") }}</option>
        @for ($y = (intVal(date("Y"))-1); $y > 2010; $y--)
            <option value="{{ $y }}" @if (intVal($archYear) == intVal($y)) SELECTED @endif >{{ $y }}</option>
        @endfor
        </select></nobr>
    </div></div></td></tr></table>
</div>
@endif <?php /* end !$isPrint */ ?>

<?php $archSffx = (($archYear != '') ? '-' . $archYear : ''); ?>
@if ($request->has('zoom')) 
    <div class="relDiv w100 print9">
        <div class="absDiv print10"><a href="javascript:;" onmouseover="clearMapDeets();"
            ><img src="/images/maps/map-zoom1{{ $archSffx }}.png" border=0 ></a></div>
        <div class="absDiv print11"><a href="javascript:;" onmouseover="clearMapDeets();">
            <img src="/images/maps/map-zoom2{{ $archSffx }}.png" border=0 ></a></div>
        <div class="absDiv print12"><a href="javascript:;" onmouseover="clearMapDeets();">
            <img src="/images/maps/map-zoom3{{ $archSffx }}.png" border=0 ></a></div>
        <div class="absDiv print13"><a href="javascript:;" onmouseover="clearMapDeets();">
            <img src="/images/maps/map-zoom4{{ $archSffx }}.png" border=0 ></a></div>
@else 
    <div class="relDiv w100 print7">
        <div class="absDiv print8">
        @if ($isPrint) <a href="javascript:void(0)"><img src="/images/maps/map-print.png"></a>
        @else <a href="javascript:;" onmouseover="clearMapDeets();"><img src="/images/maps/map{{ $archSffx }}.png"></a>
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
    <div class="print16 w100" style="height: {{ ($map->zeros[1]-570) }}px;">
        @if ($request->has('zoom')) Burners without coordinates entered are at the bottom of the zoomed graph
        @else Burners without coordinates entered: @endif 
    </div>
</div></center>
@endif
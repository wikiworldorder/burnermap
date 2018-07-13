<!-- resources/views/vendor/burnermap/map-print.blade.php -->
{!! $map->fullPlot !!}
<div class="wBrn" style="padding: 0px 10px;">
    <a name="textList"></a>
    <table border=0 cellpadding=0 cellspacing=0 ><tr><td>
        <img src="/images/burnerMapLogoWhiteSmall.jpg" border=0 >
    </td><td class="f14">
        &nbsp;&nbsp;&nbsp;<b>BURNERMAP LEGEND</b>
    </td></tr></table>
    
    <table width=699 cellspacing=0 cellpadding=0 ><tr><td class="listPrintCols">
    @forelse ($map->campOrd as $i => $campID)
        <div class="listPrint5">{!! $map->camps[$campID] !!}</td></tr></table></div>
        @if ($i == $map->campsHalf) </td><td class="listPrintCols"> @endif
    @empty
    @endforelse
    
    @if (sizeof($map->solos) > 0)
        @foreach ($map->solos as $f) {!! $f !!} @endforeach
    @endif
    @if (sizeof($map->losts) > 0)
        <div class="listPrint3"><b>Where Oh Where Could We Be?...</b> {!! implode(', ', $map->losts) !!}</div>
    @endif
    @if (sizeof($map->skips) > 0)
        <div class="listPrint3"><b>Not Burning This Year:</b> {!! implode(', ', $map->skips) !!}</div>
    @endif
    
    </td></tr></table>
    <br />
    
    <a name="textListNotes"></a>
    @if (trim($myBurn->privateNotes) != '')
        <table border=0 cellpadding=0 cellspacing=0 style="margin-bottom: 5px;" ><tr><td>
            <img src="/images/burnerMapLogoWhiteSmall.jpg" border=0 >
        </td><td class="f14">
            &nbsp;&nbsp;&nbsp;<b>MY NOTES</b>
        </td></tr></table>
        <div class="f10">{!! $GLOBALS["util"]->printNotes($myBurn->privateNotes) !!}</div>
        <br />
    @endif
    
    @if (sizeof($map->printNotes) > 0)
        <table border=0 cellpadding=0 cellspacing=0 style="margin-bottom: 5px;" ><tr><td>
            <img src="/images/burnerMapLogoWhiteSmall.jpg" border=0 >
        </td><td class="f14">
            &nbsp;&nbsp;&nbsp;<b>NOTES FROM FRIENDS</b>
        </td></tr></table>
        <table width=699 cellspacing=0 cellpadding=0 ><tr><td class="listPrintCols">
        @foreach ($map->printNotes as $i => $note)
            {!! $note !!}
            @if ($i == floor(sizeof($map->printNotes)/2)) </td><td class="listPrintCols"> @endif
        @endforeach
        </td></tr></table>
        <br />
    @endif
    
    <center>
    <span class="f10">You have {{ number_format($map->resCnt2c) }} friends listed here.</span><br />
    <div class="listPrint4">
        <b>BURNERMAP LOVE<br />
        {{ number_format($tots["totCurrUsers"]) }}  burners connected!</b><br /><br />
        Come show the BurnerMap team some love,<br />
        Bumblepuss in Nectar Village, 8 & E<br /></b>
    </div>
    </center>
    <br /><br />
</div>
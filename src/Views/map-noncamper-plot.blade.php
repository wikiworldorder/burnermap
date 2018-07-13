<!-- map-noncamper-plot.blade.php -->
<div class="maplot" style="z-index: 3; top: {{ ($y-$pointOffY) }}px; left: {{ ($x-$pointOffX) }}px;">
    <img src="/images/pointer-small-shadow.png" border=0 >
</div>
<div id="mapPlot{{ $cnt }}" class="maplot" style="top: {{ ($y-$pointOffY) }}px; left: {{ ($x-$pointOffX) }}px;">
    <a href="javascript:;" onmouseover="showDeets({{ $cnt }});" ><img src="/images/pointer-small.png" border=0 ></a>
</div>
<div id="mapLabel{{ $cnt }}" class="maplotLab" style="top: {{ ($y-$pointOffY-1) }}px; left: {{ ($x-$pointOffX-1) }}px;">
    <a href="javascript:;" onmouseover="showDeets({{ $cnt }});" >{{ $cnt }}</a>
</div>
<div id="mapDeets{{ $cnt }}" class="maplotDeetsSolo" style="top: {{ ($y-126) }}px; left: {{ ($x-9) }}px;">
    {!! $profPic !!}<br />{{ $cnt }}. 
    @if (trim($friend->playaName) == '') <nobr>{{ $friend->name }}</nobr> 
    @else <nobr>{{ $friend->playaName }}</nobr><br /><nobr>({{ $friend->name }})</nobr> @endif
    @if ($friend->addyClock != '?:??' || $friend->addyLetter != '???')
        <br />{{ $friend->addyClock }} & {{ $friend->addyLetter }}
    @endif
</div>
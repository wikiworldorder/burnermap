<div class="maplot" style="z-index: 3; top: {{ ($int[3]-$pointOffY) }}px; left: {{ ($int[2]-$pointOffX) }}px;">
    <img src="/images/pointer-small-shadow.png" border=0 >
</div>
<div id="mapPlot{{ $cnt }}" class="maplot" 
    style="z-index: 50; top: {{ ($int[3]-$pointOffY) }}px; left: {{ ($int[2]-$pointOffX) }}px;">
    <a href="javascript:;" onmouseover="showDeets({{ $cnt }});"><img src="/images/pointer-small.png" border=0 ></a>
</div>
<div id="mapDeets{{ $cnt }}" class="maplotDeets maplotDeetsAnon" 
    style="top: {{ ($int[3]-$campLabOffY+50) }}px; left: {{ ($int[2]+$campLabOffX) }}px;">
    <b><nobr>{{ $int[0] }} & {{ $int[1] }}</nobr></b>
    {!! $int[5] !!}
</div>
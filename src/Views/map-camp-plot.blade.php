<div class="maplot" style="z-index: 3; top: {{ ($y-$pointOffY) }}px; left: {{ ($x-$pointOffX) }}px;">
    <img src="/images/pointer-small-shadow.png" border=0 >
</div>
<div id="mapPlot{{ $cnt }}" class="maplot" style="top: {{ ($y-$pointOffY) }}px; left: {{ ($x-$pointOffX) }}px;">
    <a href="javascript:;" onmouseover="showDeets({{ $cnt }});" 
        ><img src="/images/pointer-small.png" border=0 ></a>
</div>
<div id="mapLabel{{ $cnt }}" class="maplotLab" style="top: {{ ($y-$pointOffY-1) }}px; left: {{ ($x-$pointOffX-1) }}px;">
    <a href="javascript:;" onmouseover="showDeets({{ $cnt }});" >{{ $cnt }}</a>
</div>
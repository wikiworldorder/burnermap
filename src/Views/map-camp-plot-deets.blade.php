<!-- map-camp-plot-deets.blade.php -->
@if (isset($graph[1]))
    <div id="mapDeets{{ $graph[1] }}" class="maplotDeets" 
        style="top: {{ ($y-$campLabOffY) }}px; left: {{ ($x+$campLabOffX) }}px;">
        <table border=0 cellpadding=0 cellspacing=3 ><tr><td colspan=2 class="maplotDeetsHead" >
            <nobr>{{ $graph[1] }}. {{ $camp->name }}</nobr><br />
            <nobr>{{ $camp->addyClock }} & {{ $camp->addyLetter }}</nobr>
            @if ($graph[2] > 0) <br /><nobr><span class="f8">in {{ $villDeets[$graph[2]]["name"] }}</span> @endif
        </td></tr>
        @if (isset($graph[3])) {!! $graph[3] !!} @endif </table>
    </div>
@endif
<!-- resources/views/vendor/burnermap/map.blade.php -->
@if (!$request->has('remind'))
    {!! $map->fullPlot !!}
    <center><div class="wBrn taL">

    <br /><span class="print19">
    If the address stored for you or your camp is incorrect, you can fix it with the "Edit Info" button above.</span>

    <br /><a name="textList"></a>
    <table border=0 width=100% class="burnFriends" >
    @forelse ($map->campOrd as $campID) {!! $map->camps[$campID] !!} @empty @endforelse
    @if (sizeof($map->solos) > 0)
        <tr><td colspan=4 class="condensed print2 nobord">Not In Theme Camps, But You Can Still Find Us...</td></tr>
        @foreach ($map->solos as $f) {!! $f !!} @endforeach
    @endif
    @if (sizeof($map->skips) > 0)
        <tr><td colspan=4 class="condensed print2 nobord" style="border: 0px none;">Not Burning This Year</td></tr>
        @foreach ($map->skips as $f) {!! $f !!} @endforeach
    @endif
    @if (sizeof($map->losts) > 0)
        <tr><td colspan=4 class="condensed print2 nobord">Where Oh Where Could We Be?</td></tr>
        @foreach ($map->losts as $f) {!! $f !!} @endforeach
    @endif
@else
    <center><div class="wBrn taL">
    <a href="/map">Back to Map</a><br /><br />
    <table border=0 width=100% class="burnFriends" >
@endif

@if (isset($map->absents) && sizeof($map->absents) > 0)
    <tr><td colspan=4 class="condensed print2 nobord" style="border: 0px none;">
        <div class="relDiv"><div class="absDiv" style="top: -100px; left: -50px;"><a name="notYets"></a></div></div>
        Haven't Updated Their BurnerMap Yet This Year&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        @if (!$request->has('remind'))
            <a href="javascript:;" onClick="clickNotYetsMore();" style="font-size: 12pt; color: #DDD;"
                ><u>+ Show/Hide Friends To Bother</u></a>
        @endif
    </td></tr>
    <tr><td colspan=4 class="nobord" style="margin: 0px; padding: 0px;" >
        <div id="absentee" class=" @if (time() < mktime(0, 0, 0, 8, 1, date('Y'))) disBlo @else disNon @endif ">
            <div id="absenteeBlock0" class="absentBlock" style="display: block;">
                <table border=0 width=689 class="burnAbsentFriends" ><tr>
                @if (!$request->has('remind'))
                    @foreach ($map->absents as $i => $abs)
                        @if ($i < 10)
                            @if ($i > 0 && $i%2 == 0) </tr><tr> @endif
                            {!! $abs !!}
                        @endif
                    @endforeach
                    </tr><tr>
                    <td colspan=4 class="nobord" style="margin: 0px; padding-top: 20px;" >
                    <center><a href="/map?remind=friends">Load More Friends To Bother</a></center></td>
                @else
                    <?php $blockCnt = 0; ?>
                    @foreach ($map->absents as $i => $abs)
                        @if ($i > 0 && $i%2 == 0)
                            @if ($i%100 == 0)
                                <?php $blockCnt++; ?>
                                </tr></table></div></td></tr><tr>
                                <td colspan=4 class="nobord" style="margin: 0px; padding-top: 20px;" >
                                <center><a id="absenteeMore{{ $blockCnt }}" class="absenteeMores" 
                                    @if ($blockCnt==1) style="display: block" @endif href="javascript:;" 
                                    onClick="clickNotYetsMoreMore({{ $blockCnt }});">Load More</a></center>
                                <div id="absenteeBlock{{ $blockCnt }}" class="absentBlock" >
                                <table border=0 width=689 class="burnAbsentFriends" ><tr>
                            @else </tr><tr>
                            @endif
                        @endif
                        {!! $abs !!}
                    @endforeach
                @endif
                </tr></table>
            </div>
        </div>
    </td></tr>
@endif
</table>

</div></center>
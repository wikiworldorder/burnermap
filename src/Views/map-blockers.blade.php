<!-- map-blockers.blade.php -->
@if ($all->isNotEmpty())
    <form name="blockersForm" action="?sub=1" method="post" target="_top">
    <input type="hidden" id="csrfTok" name="_token" value="{{ csrf_token() }}">
    <div class="w100" style="background: #fff; position: fixed; box-shadow: 0px 0px 5px #AAA;">
        <table border=0 class="w100" ><tr><td class="w50" style="padding: 5px 0px 0px 5px;">
            <b>Select who you want to hide from your map, and/or hide your info from theirs?</b>
        </td><td class="w50 taC">
            <center><input type="submit" value="Save Preferences" class="print24"></center>
        </td></tr></table>
    </div>
    <div style="padding-top: 60px;"><table border=0 class="w100" ><tr><td class="vaT w50">
    @foreach ($all as $i => $friend)
        <table border=0 class="w100" style="margin-bottom: 10px;" ><tr>
        <td class="vaT w5"><input type="checkbox" name="blockers[]" id="blck{{ $i }}" value="{{ $i }}"
            @if (in_array($friend->user, $myBlocks)) CHECKED @endif ></td>
        <td class="vaT w95" style="padding-top: 4px;"><label for="blck{{ $i }}">
            {!! $GLOBALS["util"]->prntFrmtName($friend, 28) !!}</label></td>
        </tr></table>
        @if ($i == floor(sizeof($all)/2)) </td><td class="vaT w50"> @endif
    @endforeach
    </td></tr></table></div>
    </form>
@else
    <i>Weird. No friends found.</i>
@endif
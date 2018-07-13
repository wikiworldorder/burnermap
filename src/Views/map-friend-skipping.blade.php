<!-- map-friend-skipping.blade.php -->
<tr>
    <td class="nobord"><img src="/images/spacer.gif" border=0 width=29 ></td>
    <td @if ($skipCnt == 0) class="nobord" @endif >{!! $profPic !!}</td>
    <td @if ($skipCnt == 0) class="nobord" @endif >
        <a href="https://www.facebook.com/app_scoped_user_id/{{ $friend->user }}" target="_blank"
            >{!! $GLOBALS["util"]->prntFrmtName($friend) !!}</a><br />
        <span class="burnernotes">{!! $GLOBALS["util"]->printNotes($friend->notes) !!}</span>
    </td>
    <td @if ($skipCnt == 0) class="nobord" @endif width=94 align=right ></td>
</tr>

<td class="nobord" width=29 style="width: 29px;"><img src="/images/spacer.gif" border=0 width=29 ></td>
<td @if ($absentCnt < 2) class="nobord" @endif width=50 style="width: 50px;">{!! $profPic !!}</td>
<td @if ($absentCnt < 2) class="nobord" @endif width=250 style="width: 250px;">
    <a href="https://www.facebook.com/app_scoped_user_id/{{ $friend->user }}" target="_blank">
    @if (trim($friend->playaName) == '') {!! $GLOBALS["util"]->formatPlayaName($friend->name, 24) !!}
    @else {!! $GLOBALS["util"]->formatPlayaName($friend->playaName, 24) !!} <br />&nbsp; ({!! 
        $GLOBALS["util"]->formatPlayaName($friend->name, 24) !!})
    @endif </a>
</td>
@if (!$isPrint)
    <tr>
        <td class="nobord"><img src="/images/spacer.gif" border=0 width=29 ></td>
        <td @if ($firstCamper) class="nobord" @endif >{!! $profPic !!}</td>
        <td class="col2 @if ($firstCamper) nobord @endif ">
            <a href="https://www.facebook.com/app_scoped_user_id/{{ $friend->user }}" target="_blank">{!! 
                $GLOBALS["util"]->prntFrmtName($friend, 28) !!}</a><br /><span class="burnernotes">
            @if (trim($friend->dateArrive) != '' || trim($friend->dateDepart) != '') 
                {{ $friend->dateArrive }}-{{ $friend->dateDepart }};
            @endif
            {!! $GLOBALS["util"]->printNotes($friend->notes) !!}</span>
        </td>
        <td @if ($firstCamper) class="nobord" @endif width=94 align=right >
            @if ($canAdd)
                <a href="https://www.facebook.com/app_scoped_user_id/{{ $friend->user }}" target="_blank"
                    ><img src="/images/addFriend.jpg" border=0 ></a>
            @endif
            {!! $tickets !!}
        </td>
    </tr>
@else
    <div class="listPrint2">{!! $GLOBALS["util"]->prntFrmtName($friend) !!}
    @if (trim($friend->dateArrive) != '' || trim($friend->dateDepart) != '') 
        <span class="burnernotes">{{ $friend->dateArrive }}-{{ $friend->dateDepart }}</span>
    @endif
	</div>
@endif
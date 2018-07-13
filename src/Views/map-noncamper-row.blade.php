<!-- map-noncamper-row.blade.php -->
@if (!$isPrint)
    <tr>
        <td class="nobord"><img src="/images/spacer.gif" border=0 width=29 ></td>
        <td @if ($first) class="nobord" @endif >{!! $profPic !!}</td>
        <td @if ($first) class="nobord" @endif >
            {{ $cnt }}. <a href="https://www.facebook.com/app_scoped_user_id/{{ $friend->user }}" target="_blank"
                >{!! $GLOBALS["util"]->prntFrmtName($friend, 28) !!}</a>
            @if ($friend->addyClock != '?:??' || $friend->addyLetter != '???') 
                - {{ $friend->addyClock }} & {{ $friend->addyLetter }}
            @endif <br /><span class="burnernotes">
            @if (trim($friend->dateArrive) != '' || trim($friend->dateDepart) != '') 
                {{ $friend->dateArrive }}-{{ $friend->dateDepart }};
            @endif
            {!! $GLOBALS["util"]->printNotes($friend->notes) !!}</span>
        </td>
        <td @if ($first) class="nobord" @endif width=94 align=right >{!! $tickets !!}</td>
    </tr>
@else
    <div class="listPrint3">{{ $cnt }}. {!! $GLOBALS["util"]->prntFrmtName($friend) !!}
    - {{ $friend->addyClock }} & {{ $friend->addyLetter }}
    @if (trim($friend->addyLetter2) != '' && $friend->addyLetter2 != '???') ({{ $friend->addyLetter2 }}) @endif
    @if (trim($friend->dateArrive) != '' || trim($friend->dateDepart) != '') 
        <span class="burnernotes">{{ $friend->dateArrive }}-{{ $friend->dateDepart }}</span>
    @endif
	</div>
@endif
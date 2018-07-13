<tr>
    <td @if ($firstCamper) class="nobord" @endif >{!! $profPic !!}</td>
    <td align=left @if ($firstCamper) class="nobord" @endif >{!! $GLOBALS["util"]->prntFrmtName($friend, 30) !!}</td>
</tr>
<!-- resources/views/vendor/burnermap/admin/text-settings.blade.php -->
<center><div class="adminMenu adminMenuPageWide">
<div class="adminHeader">Update Other Yearly Settings</div>
{!! $msg !!}

<div class="adminSpacer">
    This step mostly has to be done after placement announced, best if new maps are up first.<br />
	After updating the street names and dates for the year, then click the big button at the bottom to update the street names for all the early updaters.';
</div>
<table border=0 width=100% >
<form name="Show" action="?textSub=1" method="post">
<input type="hidden" id="csrfTok" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="year" value="{{ $y }}">
<tr><th>Setting Name</th><th>Editing {{ $y }}</th>
@for ($j = $y-1; $j > 2010; $j--) <th>{{ $j }}</th> @endfor
</tr>
@foreach ($settingList as $i => $s)
    <tr @if ($i%2 == 0) class="row2" @endif ><td>
    @if (strpos($s, 'streetLet') !== false) Street: {{ substr(str_replace('streetLet', '', $s), 2) }}
    @elseif (strpos($s, 'date') !== false) Date: {{ substr(str_replace('date', '', $s), 2) }}
    @else {{ $s }} @endif
    </td>
    <td><input type="text" name="{{ $s }}" value="{{ $settingVals[$y][$s] }}" class="f12" style="width: 140px;"></td>
    @for ($j = $y-1; $j > 2010; $j--) <td>{{ $settingVals[$j][$s] }}</td> @endfor
    </tr>
@endforeach
<tr><td>&nbsp;</td>
    <td><input type="submit" value="Save Changes" class="f14" style="padding: 10px;"></td>
    <td>&nbsp;</td>
    <td colspan={{ ($y-2012) }} ><input type="button" value="Force Update All Current Records with New Street Names" 
        class="f14" style="padding: 10px;" onClick="window.location='?resetStreets=1';"></td>
</tr>
</form>
</table>
<br /><br />

</div></center>
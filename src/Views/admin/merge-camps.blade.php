<!-- resources/views/vendor/burnermap/admin/merge-camps.blade.php -->
<form name="mergeCamps" action="/admin/merge-camps?subMerge=1" method="post">
<input type="hidden" id="csrfTok" name="_token" value="{{ csrf_token() }}">
<div style="position: fixed; top: 100px; left: 50px;">
    <input type="submit" value="MERGE 'EM!" style="font-size: 20pt; padding: 20px;">
</div>
    
<center><div class="adminMenu adminMenuPage">
<div class="adminHeader">Merge Duplicate Camps</div>

<div class="p20 f12">
@if (trim($msg) != '') <center><h3 class="red">{!! $msg !!}</h3></center> @endif
Check ONE checkbox in the right column for the best version of the camp info, for the other camps to be merged into. 
Check ONE OR MORE checkboxes in the left column for the other versions to merge in with the best version 
(DON'T CHECK the best version in the left column).
</div>
<div class="p20">
    &nbsp;X&nbsp;&nbsp;-->&nbsp;&nbsp;1<br />
@if ($camps->isNotEmpty())
	@foreach ($camps as $c)
		<a name="camp{{ $c->id }}" style="margin-top: 150px;"></a>
		<input type="checkbox" name="merger1[]" value="{{ $c->id }}">&nbsp;&nbsp;&nbsp;
		<input type="checkbox" name="merger2[]" value="{{ $c->id }}">&nbsp;&nbsp;&nbsp;
		{{ $c->name }} ({{ $c->size }}) <span class="grey">
		@if (trim($c->apiID) != '' && trim($c->apiID) != '-3')
		    <span style="font-size: 8pt;"><i>{{ $c->apiID }}</i></span>
		@endif - 
		<input type="checkbox" name="mergerAddy[]" value="{{ $c->id }}">
		{{ $c->addyClock }} & {{ $c->addyLetter }} 
		@if (trim($c->addyLetter2) != '' && $c->addyLetter2 != '???') ({{ $c->addyLetter2 }}) @endif
		</span><br />
	@endforeach
@endif
<br />
<input type="submit" value="MERGE 'EM!" style="font-size: 20pt; padding: 20px;"><br />
</form>
</div>

</div></center>
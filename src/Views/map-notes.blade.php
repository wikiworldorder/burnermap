<!-- map-notes.blade.php -->
<br /><br />
<center><div>
<form name="burnerNotes" action="?sub=1&mini=1&privNotes=1" method="post" target="hidFrame">
<input type="hidden" id="csrfTok" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="uID" value="{{ $user }}">
<div class="condensed print21">Private notes? <img src="/images/lock.png" border=0 ></div>
<div class="print22">
    to be printed on your own map: camp locations of friends who don't use Facebook, personal reminders, etc
</div>
<textarea name="privateNotes" class="mapper print23" onKeyUp="document.getElementById('savedNotes').innerHTML='';" 
    autocomplete="off" >{{ $myBurn->privateNotes }}</textarea><br />
<div class="print24"><input type="submit" class="print24" value="Save Notes" 
    onClick="document.getElementById('savedNotes').innerHTML='changes saved';"></div>
<div id="savedNotes" class="print25"></div>
</form>
</div>
<br /><br />
</center>

{!! view('vendor.burnermap.inc-friendsErrHelp')->render() !!}
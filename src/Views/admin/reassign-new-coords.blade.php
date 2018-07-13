<!-- resources/views/vendor/burnermap/admin/reassign-new-coords.blade.php -->
<center><div class="adminMenu adminMenuPage">
<div class="adminHeader">Applying New X,Y Coordinates</div>
<div class="adminSpacer taC">
    Applying newly calculated x-y coordinates to users, camps, and villages...<br />
    @if (trim($msg) == '') <h3><a href="?run=1&tbl=0">Click Here To Apply!</a></h3> @endif
</div>
{!! $msg !!}
</div></center>
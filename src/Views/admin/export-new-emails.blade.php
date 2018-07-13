<!-- resources/views/vendor/burnermap/admin/export-new-emails.blade.php -->
<center><div class="adminMenu adminMenuPage">
<div class="adminHeader">Export New Reminder Emails</div>
<div class="adminSpacer">
    <textarea class="w100" style="height: 500px;">{!! utf8_decode($csvOut) !!}</textarea>
    {!! $msg !!}
</div>
</div></center>
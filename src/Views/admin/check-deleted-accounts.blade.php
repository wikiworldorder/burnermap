<!-- resources/views/vendor/burnermap/admin/check-deleted-accounts.blade.php -->
<center><div class="adminMenu adminMenuPageWide">
<div class="adminHeader">Check For Deleted Accounts</div>
<div class="adminSpacer taC">
    Browse and click through to accounts without profile pictures to find Facebook accounts which have been deleted,
    or users who have sadly passed away.<br />
    {!! $msg !!}
</div>
@if ($users->isNotEmpty())
    @foreach ($users as $u)
        <div style="float: left; margin-bottom: 20px; font-size: 8pt;">
            <a href="https://www.facebook.com/app_scoped_user_id/{{ $u->user }}" target="_blank" 
                style="display: block; margin-bottom: 5px;">
                <img src="https://graph.facebook.com/v3.0/{{ $u->user }}/picture" width=120 height=120 border=0 ></a>
            {{ $u->user }} <a href="?start={{ $start }}&del={{ $u->user }}" 
                style="margin-left: 10px; font-size: 12pt;">x</a>
        </div>
    @endforeach
@endif
<div style="clear: both;"></div>
<a href="?start={{ ($perPage+$start) }}" class="admMenu" style="font-size: 50pt;">NEXT PAGE</a>
<br />
    
</div></center>
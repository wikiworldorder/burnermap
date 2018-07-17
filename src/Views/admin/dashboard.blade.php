<!-- resources/views/vendor/burnermap/admin/dashboard.blade.php -->
<center><table border=0 cellpadding=0 cellspacing=10 ><tr><td class="taL vaT">

    <div class="adminMenu">
        <div class="adminHeader">Recent Usage Stats</div>
        <div style="width: 699px; height: 350px;">{!! $graphStats !!}</div>
        <center><br /><span class="f8"><i>Number of...Page loads divided by 10, Page loads by unique users, 
            Edit form submissions, Edits by unique users, New users 1st time connected</i></span></center>
    </div>
    
    <div class="adminMenu">
        <div class="adminHeader">Currently Updated This Year</div>
        {!! $plotAll !!}
    </div>
    
</td><td class="taL vaT">

    <div class="adminMenu" style="width: 400px;">
        <div class="adminHeader">Admin Upkeep</div>
        @if (trim($msg) != '') <div class="adminSpacer">{!! $msg !!}</div> @endif
        <a href="/admin?refresh=1" class="admMenu">Clear All Map Caches</a>
        <a href="/admin/merge-camps" class="admMenu">Merge Duplicate Camps</a>
        <a href="/admin/check-deleted-accounts" class="admMenu">Check For Deleted Accounts</a>
        <div class="adminSpacer taC">
            {{ number_format($totActiveUsers) }} users have edited their info this year,<br />
            out of the {{ number_format($totUsers) }} who have logged in this year!
        </div>
    </div>

    <div class="adminMenu" style="width: 400px;">
        <div class="adminHeader">Manage New Year Turnover</div>
        <div class="adminSpacer taC">
            Data reset should be run between Jan-May, before placement announces. 
            Then the six-step map reset process should be run as soon as the map is released.
        </div>
        <a href="/admin/new-year-archiving" class="admMenu">1) Archive Last Year's User Data</a>
        <a href="/admin/text-settings" class="admMenu">2) Update Other Yearly Settings</a>
        <a href="/admin/import-camps-api" class="admMenu">3) Import Camps from API</a>
        <a href="/admin/upload-maps" class="admMenu">4) Upload New Map Graphics</a>
        <a href="/admin/map-tool-streets" class="admMenu">5) Set Map Grid Keypoints</a>
        <a href="/admin/map-tool-misc" class="admMenu">6) Set Landing Strip & Misc</a>
        <a href="/admin/calculate-new-coords" class="admMenu">7) Auto-Calculate Circular Grid</a>
        <a href="/admin/reassign-new-coords" class="admMenu">8) Apply New Coordinates to All</a>
        <a href="/admin/show-curr-coords" class="admMenu">Currently Stored Coordinate Translations</a>
        <a href="/admin/export-new-emails" class="admMenu">Export New Emails</a>
        
        <!---
        <div class="adminHeader">Networking Stats</div><br />
        <a href="#">...</a>
        <a href="#">...</a>
        <a href="#">...</a>
        --->
    </div>

</td></tr></table></center>
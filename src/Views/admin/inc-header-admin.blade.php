<!-- resources/views/vendor/burnermap/inc-header-admin.blade.php -->
<div id="headerBar" style="max-height: 34px;"><div id="head0" style="width: 100%;">
    <table width=100% cellpadding=0 cellspacing=0 border=0 ><tr>
    <td class="head1" style="text-align: left; padding-left: 10px;">
        <div style="margin-top: -7px;"><a href="/admin" class="condensed" style="color: #000;"
            >BurnerMap Admin Tools</a></div>
    </td><td class="headerLogin">
        <table align=right border=0 cellpadding=0 cellspacing=0 ><tr><td class="head3">
            <a href="/map">My Map</a> - <a href="/logout">Logout</a>
        </td><td class="head4">
            <img src="https://graph.facebook.com/v3.0/{{ $usr->id }}/picture" vspace=1 >
        </td></tr></table>
    </td></tr></table>
</div></div>
<div class="w100" style="height: 34px;"></div>
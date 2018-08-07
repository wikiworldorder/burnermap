<!-- resources/views/vendor/burnermap/inc-header.blade.php -->
<div id="headerBar"><center>

<div id="head0" >
    <table width=100% cellpadding=0 cellspacing=0 border=0 ><tr><td class="head1">
        <table border=0 cellpadding=0 cellspacing=0 ><tr><td class="head2">
            Spread the <img src="/images/heart.gif" border=0 > : 
        </td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
            <iframe src="https://www.facebook.com/plugins/like.php?app_id=149079168500658&amp;href=https%3A%2F%2Fburnermap.com%2Fwelcome.php&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" 
                id="headFace" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
        </td><td>
        <div id="headTwit">
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://BurnerMap.com/welcome"
                data-text="Just made a map of my friends' camps at @BurningMan with @BurnerMap! Where are YOU camping?"
                data-count="horizontal">Tweet</a>
            <script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
        </div>
        </td></tr></table>
    </td><td class="headerLogin">
        <table align=right border=0 cellpadding=0 cellspacing=0 ><tr><td class="head3">
            @if ($myBurn && isset($myBurn->playaName) && trim($myBurn->playaName) != '') {{ $myBurn->playaName }}
            @else {{ $usr->name }} @endif - 
            <a href="/logout">Logout</a>
        </td><td class="head4">
            <img src="https://graph.facebook.com/v3.0/{{ $usr->id }}/picture" vspace=1 >
        </td></tr></table>
    </td></tr></table>
</div>

<div class="head5">
    <table width=699 border=0 cellpadding=0 cellspacing=0 ><tr><td width=403 >
    <a href="https://BurnerMap.com" target="_parent"><img src="/images/headerLogo2.jpg" alt="Burner Map" border=0 ></a>
    </td><td width=170 ></td><td width=80 >
        <a href="/map/"><img id="menuMap" border=0 @if ($currPage == 'map') src="/images/menu-map-active.jpg" 
            @else src="/images/menu-map.jpg" onMouseOver="this.src='/images/menu-map-over.jpg';" 
                onMouseOut="this.src='/images/menu-map.jpg';" @endif ></a>
    </td><td width=50 align=right >
        <a href="/edit/"><img id="menuMap" border=0 @if ($currPage == 'edit') src="/images/menu-edit-active.jpg" 
            @else src="/images/menu-edit.jpg" onMouseOver="this.src='/images/menu-edit-over.jpg';" 
                onMouseOut="this.src='/images/menu-edit.jpg';" @endif ></a>
    </td><td width=75 align=right >
        <a href="/tickets/"><img id="menuMap" border=0 @if ($currPage == 'tickets') src="/images/menu-ticket-active.jpg"
            @else src="/images/menu-ticket.jpg" onMouseOver="this.src='/images/menu-ticket-over.jpg';" 
                onMouseOut="this.src='/images/menu-ticket.jpg';" @endif ></a>
    </td></tr></table>
</div>

</center></div>
<div id="headBuff"></div>
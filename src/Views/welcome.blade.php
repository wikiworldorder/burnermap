<!-- resources/views/vendor/burnermap/welcome.blade.php -->
<div id="welcHeadWrap"><center><div id="welcHead">

<div id="welcHeadBar"><table border=0 cellpadding=0 cellspacing=0 ><tr><td>
    Spread the <img src="/images/heart.gif" border=0 > : 
</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
    <iframe src="https://www.facebook.com/plugins/like.php?app_id=149079168500658&amp;href=http%3A%2F%2Fburnermap.com%2Fwelcome.php&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" 
        id="headFace" scrolling="no" frameborder="0" allowTransparency="true" ></iframe>
</td><td>
    <div id="headTwit">
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://burnermap.com/welcome.php" 
            data-text="Just made a map of my friends' camps at @BurningMan with @BurnerMap! Where are YOU camping?" 
            data-count="horizontal" data-via="micahdaigle">Tweet</a>
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>
</td></tr></table></div>

<div id="welcLogo">
    <a href="https://burnermap.com/" target="_parent"><img src="/images/headerLogo.jpg" alt="Burner Map" border=0 ></a>
</div>

</div></center></div>

<?php /*
<div id="welcLoginWrap"><center><div id="welcLogin">
<table width=450 cellpadding=0 cellspacing=0 ><tr><td width=60 style="padding: 0px;" >
<img src="https://graph.facebook.com/<?php echo $user; ?>/picture" border=1 style="border: 1px #000 solid;" >
</td><td style="padding: 0px;">
<div class="condensed" style="margin-top: -5px; padding: 0px; height: 30px; font-size: 20pt; line-height: 20px; 
    font-weight: bold;">Welcome home, <?=((trim($myBurn["playaName"]) != '') ? $myBurn["playaName"] 
    : $user_profile["first_name"])?>!</div>
<div style="padding-top: 3px; height: 11px; line-height: 11px;"><a href="<?=$_SESSION['logoutUrlFB']?>" 
    style="font-size: 11pt;">(Not <?=((trim($myBurn["playaName"]) != '') ? $myBurn["playaName"] 
    : $user_profile["first_name"])?>? Logout)</a>
<?php
if (isAdmin()) {
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?list=1&all=1" '. (($_GET["all"]) ? 'style="font-weight: bold;"' : '') 
	. '><i>Admin Map.</i></a> ';
}
?>
</div>
</td></tr></table>
</div>
*/ ?>

<div id="welcBodyWrap"><center><div id="welcBody">
    <div id="welcBodyBg"><img src="/images/welcomeBG.jpg" border=0 ></div>
    <div id="welcBodyMsg">
    @if (isset($usr) && isset($usr->id))
        Welcome, {{ $usr->name}}! Your email is {{ $usr->email }}<br /><br />
    @else
        @if (isset($loginMsg)) {{ $loginMsg }} @endif
        <b>Tracking down friends at <a href="http://burningman.org/" target="_blank">Burning Man</a> 
        used to be harder<br />
        than cleaning playa dust out of gold-sequined booty shorts.</b>
        <br /><br />
        This free app lets you and your peeps easily share camp info with<br />
        each other, generating <b>a personalized, printable map</b>. Just don't<br />
        forget to pack it along with your goggles, led fairy lights, and<br />
        Grandma Glitter's Homestyle Gamma Ray Bacon 
        Baker.<span style="font-size: 10pt;"><sup>sold separately</sup></span>
        <br /><br /><br /><br />
        <center>
        <a href="/login/facebook"><img src="/images/loginWfb.jpg" border=0 alt="Login with Facebook" ></a>
        <br /><br /><br /><br /><br /><br />
        <span style="font-size: 9pt; letter-spacing: -0.02em;">Sorry, non-Facebookers. This is a Facebook-only app. 
        <a href="/images/zuckerborg.jpg" rel="shadowbox">Don't use Facebook?</a></span>
        <br />
        </center>
    @endif
    </div>
</div></center></div>
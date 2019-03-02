<!-- resources/views/vendor/burnermap/welcome.blade.php -->
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
        <a href="/login/facebook"
            ><img src="/images/facebook-continue-with.png" border=0 alt="Login with Facebook" style="width: 50%;" ></a>
        <br /><br /><br /><br /><br /><br />
        <span style="font-size: 9pt; letter-spacing: -0.02em;">Sorry, non-Facebookers. This is a Facebook-only app. 
        <a href="/images/zuckerborg.jpg" rel="shadowbox">Don't use Facebook?</a></span>
        <br />
        </center>
    @endif
    </div>
</div></center></div>
<!doctype html><html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
    <meta http-equiv="Content-Type" content="Text/HTML" />
    <meta charset="UTF-8" />
    <title>BURNER MAP. A printable map of your pals on the playa.</title>
    <meta name="keywords" content="Burner Map, Burning Man, Black Rock City, map, facebook, playa, 2018, 2011" />
    <meta name="description" content="Tracking down friends in Black Rock City used to be harder than cleaning playa 
        dust out of gold-sequined booty shorts. Now you can share your camp location, ask your friends to do the same, 
        then print and pack your playa map along with your goggles, glowsticks, and Grandma Glitter's Homestyle Gamma 
        Ray Bacon Baker. (sold separately)" />
    <link rel="shortcut icon" href="/images/favicon.png" />
    <link rel="image_src" href="/images/logo2.png">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/lib/burner.css">
    <link rel="stylesheet" type="text/css" href="/js/shadowbox-3.0.3/shadowbox.css">
    <script type="text/javascript" src="/js/shadowbox-3.0.3/shadowbox.js"></script>
    <script type="text/javascript"> Shadowbox.init(); </script>
    <script type="text/javascript" src="/lib/burner.js"></script>
    @if (isset($headCode)) {!! $headCode !!} @endif
</head>
<body onscroll="bodyOnScroll();" @if ($request->has('print')) style="background: #FFF;" @elseif ($currPage == 'admin') 
    style="background: url(https://graph.facebook.com/v3.0/{{ $usr->id }}/picture?type=normal);" @endif >

@if (!$request->has('print'))
    @if (isset($header)) {!! $header !!} @endif
    {!! $GLOBALS["util"]->printSessMsg() !!}
    @if (isset($notifs)) {!! $notifs !!} @endif
@endif

@if (isset($mainout)) {!! $mainout !!} @endif

@if (!$request->has('print') && $currPage != 'admin')
    <div id="footerDiv"><center>
        <div id="foot1" class="footOrange">
            <table border=0 ><tr>
            <td class="foot2">{{ number_format($tots["totUsers"]) }}</td>
            <td class="foot3"><i>Homo sapiens</i> have connected<br />with BurnerMap, 
            @if ($tots["totCurrUsers"] > 1000) {{ floor($tots["totCurrUsers"]/1000) }}K in {{ date("Y") }}.
            @else {{ $tots["totCurrUsers"] }} in {{ date("Y") }}. 
            @endif </td></tr></table>
        </div>
        <div class="relDiv" id="foot4"><center>
            <span class="feets"><span class="footOrange"><b>Embrace serendipity.</b></span><br />
            
            We encourage you to use this map sparingly. May the forces of chance,<br />
            intuition, and magic bring you new life-long friendships!
            <br /><br />
            
            <span class="footOrange"><b>Your privacy.</b></span><br />
            We have lots of love for our fellow burners and promise not to do stupid or selfish things with the info you 
            entrust to us. Our lawyer friends told us we need to say more than that, so here's our 
            <a href="/privacy">Privacy Policy</a>.<br /><br />
            
            <center>
            <img src="/images/miniMapIcon.png" border=0 ><br /><br />
            
            <span class="footOrange"><b>BurnerMap is a little playa gift from...</b></span><br />
            <a href="/images/morgasm.jpg" rel="shadowbox">Morgasm</a> 
            (<span class="feetSubtle"><a href="http://WikiWorldOrder.org" target="_blank">Morgan</a></span> 
                <span class="feetSubtle"><a href="http://WikiWorldOrder.org" target="_blank">Lesko</a></span>): Code  |  
            <a href="/images/littlespoon.jpg" rel="shadowbox">Little Spoon</a> (Micah Daigle): Design / UX<br />
            <a href="/images/tdazzl.jpg" rel="shadowbox">TDazzl</a> (Troy Dayton): Brainstorming  |  
            <a href="/images/brandl.jpg" rel="shadowbox">Brandl</a>: Unspeakable Acts of 
            <span class="feetSubtle"><a href="http://consumptionblog.com" target="_blank">Indecency</a></span>
            <br /><br />
            
            <span class="footOrange"><b>With donations from hundreds of users, Matt Mullenweg, 
            <nobr>and <a href="https://info.terratori.com/" target="_blank"
                >Terratori Technologies</a></nobr>
            &lt;3</b><br /><br />
            
            <b>Shoutouts to some of our burner friends who create awesome things...</b></span><br />
            <a href="http://bluemorphocenternews.wordpress.com/" target="_blank">Blue Morpho</a>, 
            <a href="http://burningmanrides.com/" target="_blank">BurningManRides</a>, 
            <a href="http://bumblepuss.com/" target="_blank">Camp Bumblepuss</a>,<br />
            <a href="http://dojo.com/" target="_blank">Dojo</a>, 
            <a href="https://iburnapp.com" target="_blank">iBurn</a>, 
            <a href="https://www.facebook.com/TimeToBurnApp/" target="_blank">Time To Burn</a>, and 
            <a href="http://www.nectarvillage.com/" target="_blank">Nectar Village</a><br /><br />
            
            With special thanks to <a href="/images/zuckerborg.jpg" rel="shadowbox">The Zuckerborg</a>. 
            Best with Firefox or Chrome, not IE.
            <br /><br />
            <a href="https://github.com/wikiworldorder/burnermap" target="_blank"
                ><img src="/images/github.png" border=0 height=40 ><br />Help our code on GitHub</a><br />
        </center></div>
    </center></div>
    
    <a name="donate"></a>
    <div id="foot6"><center>
        <br /><span class="f12">BurnerMap turn you on? Consider donating to help keep the server sparkly!</span><br />
        <table border=0 ><tr><td>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHLwYJKoZIhvcNAQcEoIIHIDCCBxwCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYASnTmlN0bK+3OWl/i12ZDz1QrZLIrUCl4/+3soC56BHtXyFVX+vrGdwExEsxPMODXVMgzv8GQMpT115tqb3gDjNHh+UwyKcdw+sXbrnnOgqCeovL1dUSA0qo0E99R4pX55z+JLa4RLOnrVyOx+AZJMt1YvadUQVfnUQQ+gIZgAmTELMAkGBSsOAwIaBQAwgawGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIO0BTJrOF6lmAgYjxWAT5Q3EybBTs6kxkxnSN2tve4b8LwNorU/YHo8gpOAjZUwz5ai0s9kFgwdcmq94vVFKHmcQ3X8fzOQPRYlwoIJ319gtIr+ukbgERGx2cdnC571aFTZjCR7dfpnOZ9zEK2K1K+gjeT6rBX1iegz31ZdSYQ/6C3dkyhjDjNwi4U0rCN2rYTbuLoIIDhzCCA4MwggLsoAMCAQICAQAwDQYJKoZIhvcNAQEFBQAwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tMB4XDTA0MDIxMzEwMTMxNVoXDTM1MDIxMzEwMTMxNVowgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBR07d/ETMS1ycjtkpkvjXZe9k+6CieLuLsPumsJ7QC1odNz3sJiCbs2wC0nLE0uLGaEtXynIgRqIddYCHx88pb5HTXv4SZeuv0Rqq4+axW9PLAAATU8w04qqjaSXgbGLP3NmohqM6bV9kZZwZLR/klDaQGo1u9uDb9lr4Yn+rBQIDAQABo4HuMIHrMB0GA1UdDgQWBBSWn3y7xm8XvVk/UtcKG+wQ1mSUazCBuwYDVR0jBIGzMIGwgBSWn3y7xm8XvVk/UtcKG+wQ1mSUa6GBlKSBkTCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb22CAQAwDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQUFAAOBgQCBXzpWmoBa5e9fo6ujionW1hUhPkOBakTr3YCDjbYfvJEiv/2P+IobhOGJr85+XHhN0v4gUkEDI8r2/rNk1m0GA8HKddvTjyGw/XqXa+LSTlDYkqI8OwR8GEYj4efEtcRpRYBxV8KxAW93YDWzFGvruKnnLbDAF6VR5w/cCMn5hzGCAZowggGWAgEBMIGUMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbQIBADAJBgUrDgMCGgUAoF0wGAYJKoZIhvcNAQkDMQsGCSqGSIb3DQEHATAcBgkqhkiG9w0BCQUxDxcNMTUwNzMxMTQ1MzUxWjAjBgkqhkiG9w0BCQQxFgQURaFxAchwHhS+/zIQutYZ0XsOz/QwDQYJKoZIhvcNAQEBBQAEgYBXVNziqXG9mxhZL5W685uQZJqb5rD2knjOBRsIdZY8YwHGf4xaMtEPIDKaCpYeWb0dgwmG7Aiv4rKX3vA/7zkgPwatoULvVkqcFtkDSO0osR7gIuhfe32r9Fkz/iK/EWwAd5pIJpWUau71FC8kbUoWDtgtDkcdWTN6GaOW2/naIA==-----END PKCS7-----
        ">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" 
            alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
        </td>
        <td style="padding: 0px 20px; font-size: 10pt; vertical-align: middle; font-weight: normal;"><i>or</i></td>
        <td><a href="https://www.patreon.com/morganlesko" target="_blank"
            ><img src="/images/patreon_navigation_logo_mini_orange.png" border=0 height=30 ></a></td>
        <td style="padding-left: 20px; font-size: 8pt; vertical-align: middle; font-weight: normal;"><i>or</i>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1BLcNNL4bv8fQ8d4XN9KXt7T2LU2pjLMN5</td>
        <td><a href="/images/qr-code.jpg" rel="shadowbox"><img src="/images/bitcoin.png" height=30 border=0 >
            <img src="/images/qr-code.jpg" height=30 border=0 ></a></td>
        </tr></table>
    </center></div>
    
    <a href="https://www.facebook.com/BurnerMap" id="feedbackright" target="_blank">feedback</a> 
    <!--- https://www.facebook.com/apps/application.php?id=149079168500658&sk=wall --->
@endif

<div class="hid"><iframe id="hidFrameID" name="hidFrame" src=""></iframe></div>

<script type="text/javascript">

@if (isset($java)) {!! $java !!} @endif
@if (isset($ajax)) $(document).ready(function(){ {!! $ajax !!} }); @endif

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-24758322-1']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

</body></html>

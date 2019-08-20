<!-- resources/views/vendor/burnermap/tickets.blade.php -->
<center><div class="wBrn taL">

<table width=699 align=center border=0 cellpadding=0 cellspacing=0 ><tr><td class="ticket0 f12">

<div class="condensed ticket1">Help Friends.<br />
Screw Scalping.</div>
<table border=0 cellpadding=0 cellspacing=0 ><tr><td>
<iframe src="https://www.facebook.com/plugins/like.php?app_id=234775309892416&amp;href=http%3A%2F%2Fburnermap.com%2Ftickets%2F&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" 
    scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" 
    allowTransparency="true"></iframe>
</td><td>
<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://burnermap.com/tickets" 
    data-text="Need a #BurningMan ticket? Got an extra? @BurnerMap has a new matchmaking tool for face-value ticket exchange!" 
    data-count="horizontal">Tweet</a>
</td></tr></table>
<br />
<nobr><span class="f12"><b>BurnerMap now matches up burners</nobr><br />
<nobr>in need with friends who have extras.</b></nobr><br />
<br />
<nobr>There is no charge for this nifty service.</nobr><br />
<nobr><a href="#donate" style="font-size: 11pt;">
    (But if it turns you on, slip a bill into our fishnets!)
</a></nobr><br />
<br />
<nobr>Just please <b>gift</b> tickets or sell at <b>face</nobr><br />
<nobr>value</b> because <b>scalping is worse than</nobr><br />
shirtcocking.</b></span><br />
<br />
Even though this tool helps you find friends<br />
to make exchanges with, you should still<br />
<a href="http://blog.burningman.com/2011/08/news/known-ticket-scams/" target="_blank"
    ><b>be aware of possible scams</a>.</b><br />

</td><td class="ticket2" >

<form name="ticketForm" action="?ticketSub=1#thankYou" method="post">
<input type="hidden" id="csrfTok" name="_token" value="{{ csrf_token() }}">
<table border=0 width=100% >
<tr><td><input type="radio" id="ticketType1" name="ticketType" value="need" onClick="return clickNeed();" 
    @if ($myBurn->ticketNeeds > 0) CHECKED @endif ></td>
    <td class="condensed f14"><nobr><label for="ticketType1">I need tickets</label></nobr></td>
    <td><div id="needTicketsHow" @if ($myBurn->ticketNeeds > 0) style="display: block;" @endif >
        <nobr>How many? <select name="howManyNeed">
        @for ($i = 0; $i < 10; $i++)
            <option value="{{ $i }}" @if ($myBurn->ticketNeeds == $i) SELECTED @endif >{{ $i }}</option>
        @endfor
	</select></nobr></div></td>
</tr>

<tr><td colspan=4 ><br /></td></tr>
<tr><td><input type="radio" id="ticketType2" name="ticketType" value="have" onClick="return clickHave();" 
    @if ($myBurn->ticketHas > 0) CHECKED @endif ></td>
    <td class="condensed f14"><nobr><label for="ticketType2">I have extra tickets</label></nobr></td>
    <td><div id="haveTicketsHow" @if ($myBurn->ticketHas > 0) style="display: block;" @endif >
        <nobr>How many? <select name="howManyHave">
	@for ($i = 0; $i < 10; $i++)
		<option value="{{ $i }}" @if ($myBurn->ticketHas == $i) SELECTED @endif >{{ $i }}</option>
	@endfor
	</select></nobr></div></td>
</tr>

<tr><td colspan=4 ><br /></td></tr>
<tr><td><input type="radio" id="ticketType3" name="ticketType" value="help" onClick="return clickNeither();"
    @if ($myBurn->ticketHas == 0 && $myBurn->ticketNeeds == 0) CHECKED @endif  ></td>
    <td colspan=3 class="condensed f14"><nobr><label for="ticketType3">Neither</label>
        </nobr></td></tr>

<tr><td colspan=4 ><br /></td></tr>
<tr><td colspan=4 ><center><input type="image" src="/images/ticket-save.jpg" border=0 
    onClick="document.ticketForm.submit();" ></center></td></tr>
@if ($myBurn->ticketNeeds > 0 || $myBurn->ticketHas > 0 || $myBurn->opts%7 == 0)
	<tr><td colspan=4 ><center><br /><br /><a @if ($myBurn->ticketHas > 0) href="/tickets-instruct-have?print=1"
	    @elseif ($myBurn->ticketNeeds > 0) href="/tickets-instruct-need?print=1" 
	    @else href="/tickets-instruct-help?print=1" @endif 
	    rel="shadowbox;height=600;width=540" class="f10">Remind me of the instructions</a></center></td></tr>
@endif
</table>
</form>

</td></tr>

@if ($isAdmin)
    <tr><td colspan=2 ><center>
    <br />
    <div class="condensed f28">&nbsp;Total Needed Tickets - Total Extra Tickets</div>
    <div class="f12" style="padding-bottom: 5px;">&nbsp;&nbsp;&nbsp;(currently in BurnerMap)</div>
    </center></td></tr>
    <tr><td><center>
    <div class="relDiv" style="background: url(/images/ticket-big.jpg); background-repeat: no-repeat; 
        width: 300px; height: 128px;">
    <div class="absDiv taC" style="top: 26px; left: 30px; width: 220px; font-size: 60pt; color: #f95144;">
    -{{ $totTickets[0] }}
    </div></div>
    </center></td><td><center>
    <div class="relDiv" style="background: url(/images/ticket-big.jpg); background-repeat: no-repeat; 
        width: 300px; height: 128px;">
    <div class="absDiv taC" style="top: 26px; left: 30px; width: 220px; font-size: 60pt; color: #4cb77e;">
    +{{ $totTickets[1] }}
    </div></div>
    </center></td></tr>
@endif

</table><br /><br />

<script type="text/javascript">
function clickNeed() {
	document.getElementById('needTicketsHow').style.display = 'block';
	document.getElementById('haveTicketsHow').style.display = 'none';
	return true;
}
function clickHave() {
	document.getElementById('haveTicketsHow').style.display = 'block';
	document.getElementById('needTicketsHow').style.display = 'none';
	return true;
}
function clickNeither() {
	document.getElementById('haveTicketsHow').style.display = 'none';
	document.getElementById('needTicketsHow').style.display = 'none';
	return true;
}
</script>

</div></center>
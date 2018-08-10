<div class="edit16" style=" @if (sizeof($tot) > 0) height: 127px; background: url(/images/editInstructs.jpg);
    @else height: 86px; background: url(/images/editInstructs2.jpg); @endif ">
	<center><div class="edit17">
        {!! $blobber !!}
        <center>
        @if (trim($blobber) != '') <b>{{ number_format($tot) }} of your Facebook friends</b> have used BurnerMap!
        @else <b>You are the first of your Facebook friends to use this app!</b> @endif
        <br />Enter any info you know below and then check out your map.<br />
        <b>All fields are optional</b>, and you can come back & edit any time.
        </center>
	</div></center>
</div></center>
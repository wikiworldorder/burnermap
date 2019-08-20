@if ($friend->ticketNeeds > 0)
    <div class="ticketRightShell1" align=right >
        <div class="ticketRightBG" onClick="return openFBmsgWin({{ $friend->user }});" 
            onmouseover="this.style.cursor='pointer'; showTip({{ $cntTot }});" 
            onmouseout="this.style.cursor='hand'; hideTip({{ $cntTot }});">
            <div class="ticketRightColNeeds">-{{ $friend->ticketNeeds }}</div>
        </div>
        <div id="ticketTip{{ $cntTot }}" class="ticketTip">
            <img src="/images/ticket-tooltip-need{{ (($friend->ticketNeeds == 1) ? '1' : '2') }}.png" border=0 >
        </div>
    </div>
@elseif ($friend->ticketHas > 0)
    <div class="ticketRightShell1" align=right >
        <div class="ticketRightBG" onClick="return openFBmsgWin({{ $friend->user }});" 
            onmouseover="this.style.cursor='pointer'; showTip({{ $cntTot }});" 
            onmouseout="this.style.cursor='hand'; hideTip({{ $cntTot }});">
            <div class="ticketRightColHas">+{{ $friend->ticketHas }}</div>
        </div>
        <div id="ticketTip{{ $cntTot }}" class="ticketTip">
            <img src="/images/ticket-tooltip-have{{ (($friend->ticketHas == 1) ? '1' : '2') }}.png" border=0 >
        </div>
    </div>
@endif
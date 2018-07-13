@if (!$isPrint)
    <tr>
        <td colspan=4 class="condensed print1 nobord">
        {{ $cnt }}. {{ $camp->name }} 
        @if (isset($camp->description) && trim($camp->description) != '')
            <a href="javascript:;" id="campInfoBtn{{ $camp->id }}"><img src="/images/info.png" class="infoImg" ></a>
        @endif - {{ $camp->addyClock }} & {{ $camp->addyLetter }}
        @if (trim($camp->addyLetter2) != '' && $camp->addyLetter2 != '???') 
            <span class="f12 nobld">({{ $camp->addyLetter2 }})</span>
        @endif
        @if ($camp->villageID > 0 && $vill && isset($vill->name))
            <span class="f12">in {{ $vill->name }} 
            @if ((trim($vill->addyClock) != '' && $vill->addyClock != $camp->addyClock)
                || (trim($vill->addyLetter) != '' && $vill->addyLetter != $camp->addyLetter))
                ({{ $vill->addyClock }} & {{ $vill->addyLetter }})
            @endif </span>
        @endif
        @if (isset($camp->description) && trim($camp->description) != '') 
            <div id="campInfo{{ $camp->id }}" class="campDesc">{{ $camp->description }}
                @if (isset($camp->url) && trim($camp->url) != '') 
                    <br /><a href="{{ $camp->url }}" target="_blank"><i>{{ $camp->url }}</i></a>
                @endif
            </div>
        @endif
        </td>
    </tr>
@else
    <table border=0 cellpadding=0 cellspacing=0 ><tr>
    <td class="listPrint1">{{ $cnt }}.</td>
    <td class="vertTop"><div class="listPrint1">
        {{ $camp->name }} <span class="f8">- {{ $camp->addyClock }} & {{ $camp->addyLetter }}
        @if (trim($camp->addyLetter2) != '' && $camp->addyLetter2 != '???') ({{ $camp->addyLetter2 }}) @endif
        @if ($camp->villageID > 0 && $vill && isset($vill->name))
            <span class="mLn5" style="color: #666;">&nbsp;, in {{ $vill->name }} </span>
        @endif
        </span>
    </div>
@endif
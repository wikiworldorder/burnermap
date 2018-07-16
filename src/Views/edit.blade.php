<!-- resources/views/vendor/burnermap/edit.blade.php -->

<script type="text/javascript" src="/lib/camps.js"></script>
<script type="text/javascript" src="/lib/edit.js"></script>

<center><div class="bodyWrapMin">

{!! $prevUsers !!}

<center><div id="edit0">
	<form name="burnerDeets" action="?sub=1" method="post" onSubmit="onEditSubmit();">
	<input type="hidden" id="csrfTok" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="uID" value="{{ $myBurn->user }}">
	<input type="hidden" id="MouseXID" name="MouseX" value="{{ $myBurn->x }}" size="4">
	<input type="hidden" id="MouseYID" name="MouseY" value="{{ $myBurn->y }}" size="4">
	<div class="condensed editCenter editF16">My name in the default world is<br />{{ $myBurn->name }}.<br />
		<input type="checkbox" id="burnThisYearID" name="burnThisYear" value="1" autocomplete="off" 
		    @if ($myBurn->yearStatus == 'Skipping') CHECKED @endif onChange="onChangeYearStatus(this.checked);"> 
		<label for="burnThisYearID"><span style="font-size: 10pt;">I'm not going to Burning Man this year</label>
		    <br /><br /></span>
	</div>
	
	<center><div id="notGoingNotes" class="
	    @if ($myBurn->yearStatus == 'Skipping') disBlo @else disNon @endif "><center>
		<div class="condensed editF16">Notes for friends</div>
			<div class="editFldNotes">Shout outs, etc</div>
		<textarea id="notes2ID" name="notes2" style="height: 97px; width: 450px; font-size: 10pt;" class="mapper" 
		    onKeyUp="onKeyNotes();" autocomplete="off" ><?= 
		    str_replace('[[[heart]]]', '<3', $myBurn["notes"]) ?></textarea><br /><br />
	</center></div></center>
	
	<div id="edit2" class="relDiv @if ($myBurn->yearStatus == 'Skipping') disNon @else disBlo @endif " >
		<div class="editLeft condensed editF16">My playa name is</div>
		<div class="editRight">
			<input type="text" name="playaName" value="{{ $myBurn->playaName }}" class="mapper" 
			    style="font-size: 18pt;" onFocus="return autoBox(0);" autocomplete="off">
			<div class="editFldNotes"><nobr>Leave blank if you don't have a playa name yet. You will.</nobr></div>
			<br />
		</div>
		<div class="editClear"></div>
		
		<div class="editLeft condensed editF16">My camp name is</div>
		<div class="editRight">
			<div id="campNameDrop" class="edit7 @if ($myBurn->campID > 0) disBlo @else disNon @endif " >
				<select id="campIDid" name="campID" class="edit8 mapper" onChange="loadCampInfo(this.value);" 
				    style="font-size: 14pt;" autocomplete="off">
					<option value="0" @if ($myBurn->campID == 0 || $myBurn->yearStatus == 'None') SELECTED @endif 
					    style="color: #666;">Select...</option>
					<option value="-3" @if ($myBurn->campID == -3) SELECTED @endif style="color: #333;"
					    >Add my theme camp, which is not yet on this list</option>
					<option value="-1" @if ($myBurn->campID == -1 && $myBurn->edits != 0) SELECTED @endif 
					    style="color: #333;" >I'm not with a theme camp</option>
					<option DISABLED style="color: #333;" >--camp name-- (size on BurnerMap) --address--</option>
					<option DISABLED ></option>
					{!! $campOpts !!}
				</select><br />
				<!--- <nobr><span style="color: #ff908f; font-size: 10pt;"><b>Not on the list yet?</b></span>
				<a href="javascript:;" onClick="document.getElementById('campIDid').value='-3'; loadCampInfo(-3);"
				    style="font-size: 10pt; font-weight: bold;">Add it!</a></nobr>--->
			</div>
			<div id="campNameText" class=" @if ($myBurn->campID > 0) disNon @else disBlo @endif " >
				<input type="text" id="campID" name="camp" onKeyUp="return fillDiv(this.value);" autocomplete="off" 
				    value="{{ $myBurn->camp }}" class="mapper" style="font-size: 18pt; width: 280px;" >
				<div id="autoCompShell"></div>
				<div class="editFldNotes">
					<nobr>Type in camp name. Or leave blank.</nobr><br />
					<!--- <a href="javascript:;" 
                        onClick="document.getElementById('campNameDrop').style.display='block'; 
                        document.getElementById('campNameText').style.display='none';">list</a> --->
				</div>
			</div>
			<div class="editFldNotes" style="height: 15px;">
                <div id="villageLink" class=" @if ($myBurn->villageID > 0) disNon @else disBlo @endif "><nobr>
                    <a href="javascript:;" onClick="document.getElementById('villageBlock').style.display='block';
                        document.getElementById('villageLink').style.display='none';">Is your camp part of a village?
                        </a></nobr></div>
			</div>
		</div>
		<div class="editClear"></div>
		
		<div id="villageBlock" class=" @if ($myBurn->villageID > 0) disBlo @else disNon @endif " >
			<div class="editLeft condensed editF16">My village name is</div>
			<div class="editRight">
				<select id="villageIDid" name="villageID" class="edit8 mapper" style="font-size: 14pt;" 
				    onFocus="return autoBox(0);" onChange="onChangeVillage(this.value);" autocomplete="off">
					<option value="-1" @if ($myBurn->campID < 0 || $myBurn->yearStatus == 'None') SELECTED @endif 
					    style="color: #333;" >Not in a village</option>
					<!--- <option value="0" style="color: #333;" >--village name--(size on BurnerMap)--</option> --->
					{!! $villOpts !!}
				</select><br /><br />
			</div>
			<div class="editClear"></div>
		</div>
		
		<div id="mapFields1" class="editLeft condensed editF16 
		    @if ($myInfo->myCampHasCoords) disNon @else disBlo @endif">Friends find me at</div>
		<!--- <div class="absDiv" style="top: 175px; font-size: 10pt; color: #999;">
		    <a href="http://www.burningman.com/preparation/maps/11_maps/index.html" target="_blank" 
		    style="font-size: 9pt;">click here</a> for playa map</div> --->
		<div class="editRight">
			<div id="mapFields2" class="condensed editF16 @if ($myInfo->myCampHasCoords) disNon @else disIn @endif ">
				<nobr><select id="addyClockID" name="addyClock" class="mapper edit9" autocomplete="off">
				@foreach ($vars->streetClocks as $i => $s)
					<option value="{{ $s }}" @if ($s == $myBurn->addyClock) SELECTED @endif
					    @if ($s == '4:20') style="color: #007005;"
					    @elseif (($i > 0 && $i < 5) || $i > 101) style="color: #007397;"
					    @endif >{{ $s }}</option>
				@endforeach
				</select> & <select id="addyLetterID" name="addyLetter" class="mapper edit10" autocomplete="off">
				@foreach ($vars->streetLetters as $i => $s)
					<option value="{{ $s }}" @if ($s == $myBurn["addyLetter"]) SELECTED @endif
					    @if ($i > 15) style="color: #007397;" @endif >{{ $s }}</option>
				@endforeach
				</select></nobr>
			</div>
			
			<div id="mapFields5desc" class=" @if ($myInfo->myCampHasCoords) disNon @else disBlo @endif ">
				<div class="editFldNotes">
					<nobr><a id="editFldNot" href="javascript:;" onClick="clickFldNote();"
					    >Know which side of the street you're on?</a></nobr><br />
				</div>
			</div>
			<div id="mapFields5">
				<select id="addyLetter2ID" name="addyLetter2" autocomplete="off">
					<option value="???" @if ($s == $myBurn["addyLetter2"]) SELECTED @endif 
					    >Which side of the street? (if known)</option>
					<option value="Man-side" @if ($myBurn["addyLetter2"] == 'Man-side') SELECTED @endif 
					    >Man-side (closer to the man)</option>
					<option value="Mountain-side" @if ($myBurn["addyLetter2"] == 'Mountain-side') SELECTED @endif
					    >Mountain-side (closer to edge of city)</option>
				</select><br />
			</div>
			
			<div id="mapFieldsStatic" class="condensed @if ($myInfo->myCampHasCoords) disBlo @else disNon @endif ">
				@if ($myBurn->campID > 0 && $myInfo->myCampHasCoords)
					<nobr> @if (isset($myInfo->myCamp->who) && $myInfo->myCamp->who == '???') A campmate 
					@elseif (isset($myInfo->myCamp->who)) {{ $myInfo->myCamp->who }} @endif 
					set the camp address to {{ $myInfo->myCamp->addyClock }} & {{ $myInfo->myCamp->addyLetter }}</nobr>
				@endif
			</div>
			<div id="mapFieldsStatic2" class=" @if ($myInfo->myCampHasCoords) disBlo @else disNon @endif ">
				<div class="editFldNotes">
				    <b>Is this wrong?</b></span> 
				    <a class="helv" href="javascript:;" onClick="changeCoords();">Change it!</a>
				</div>
			</div>
			<br />
		</div>
		<div class="editClear"></div>
		
		<div class="editLeft"><div class="condensed editF16">Notes for friends</div>
			<div class="editFldNotes">Camp description,<br />landmarks, event times,<br />request more campers,<br />
			    shout outs, etc</div>
		</div>
		<div class="editRight"><textarea id="notesID" name="notes" class="mapper" autocomplete="off"
		    ><?= str_replace('[[[heart]]]', '<3', $myBurn->notes) ?></textarea><br /><br /></div>
		<div class="editClear"></div>
		
		<div class="editLeft condensed editF16" style="width: 450px;">
		    <nobr>I'm on the playa from 
			<select name="dateArrive" class="dateInOut mapper" autocomplete="off"> {!! $dateArriv !!} </select> to 
			<select name="dateDepart" class="dateInOut mapper" autocomplete="off"> {!! $dateDepart !!} </select>
			</nobr><br /><br />
        </div>
		<div class="editClear"></div>
		
		<div id="shareWithCamp" class=" @if ($myBurn->yearStatus != 'None' && $myBurn->campID > 0) disBlo @else disNon 
		    @endif "><nobr>&nbsp;&nbsp;&nbsp;
		    <input type="checkbox" id="shareWithCampID" name="shareWithCamp" value="1" autocomplete="off" 
		        @if ($myBurn->opts%3 == 0 && $myBurn->yearStatus != 'None') CHECKED @endif > 
			<label for="shareWithCampID">Share my info with my campmates.</label></nobr>
			<div id="shareWithVillage" class=" @if ($myBurn->villageID > 0) disBlo @else disNon @endif "
			    style="padding-top: 10px;">
				<nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="checkbox" id="shareWithVillID" name="shareWithVill" value="1" autocomplete="off" 
				    @if ($myBurn->yearStatus != 'None' && $myBurn->opts%13 == 0) CHECKED @endif
				    onClick="clickShareVillage();" > 
				<label for="shareWithVillID">Share with my villagemates too.</label></nobr>
			</div>
			<div class="editNotes" style="margin-left: 0px;">
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    Even if we aren't friends on Facebook yet.
			</div><br />
		</div>
		
		<div id="emailFld1" class="editLeft disBlo condensed editF16">My email address is<br /></div>
		<div id="emailFld2" class="editRight disBlo">
		    <input type="text" id="emailID" name="email" value="{{ $myBurn->email }}" class="mapper"
		        autocomplete="off" ></div>
		<div class="editClear"></div>
		<div class="edit14">
		    <?php /* <input type="checkbox" id="emailRemindID" name="emailRemind" value="1" 
                @if ($myBurn->yearStatus == 'None' || intVal($myBurn->emailRemind) == 1) CHECKED @endif
                onClick="if (!this.checked) { document.getElementById('emailFld1').style.display='none'; 
                    document.getElementById('emailFld2').style.display='none'; } else { 
                    document.getElementById('emailFld1').style.display='block'; 
                    document.getElementById('emailFld2').style.display='block'; }"> */ ?>
			<span class="editNotes"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;
			We'll remind you to print your map a week beforehand, give you a heads-up</nobr><br />
			<nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;about stupendous BurnerMap updates, 
			but won't spam you with e-moop.</nobr></span><br /><br />
		</div>
	
	</div> <!-- main relDiv, edit2 -->
	
	<center><input id="editSubBtn" type="image" src="/images/buuuurn-button.png" onClick="clickEditSubBtn();"></center>
	</form>
	
</div> <!-- edit0 -->
<br /><br />
</center>

</div></center>
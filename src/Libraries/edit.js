
function onEditSubmit() {
    document.getElementById('notesID').value=document.getElementById('notesID').value.replace('<3', '[[[heart]]]');
}

function onChangeYearStatus(ischecked) {
    if (!ischecked) { 
        document.getElementById('edit2').style.display='block'; 
        document.getElementById('notGoingNotes').style.display='none'; 
        
    } else { 
        document.getElementById('edit2').style.display='none';
        document.getElementById('notGoingNotes').style.display='block'; 
        document.getElementById('notes2ID').value=document.getElementById('notesID').value; 
    }
}

function onKeyNotes() {
    document.getElementById('notesID').value=document.getElementById('notes2ID').value;
}

function onChangeVillage(newval) {
    if (this.value > 0) document.getElementById('shareWithVillage').style.display='block'; 
    else document.getElementById('shareWithVillage').style.display='none';
}

function loadCampInfo(campID) {
	if (campID == -3) {
		document.getElementById('campNameDrop').style.display='none'; 
		document.getElementById('campNameText').style.display='block'; 
		document.getElementById('mapFields1').style.display='block';
		document.getElementById('mapFields2').style.display='block';
		document.getElementById('mapFields5').style.display='none';
		document.getElementById('mapFields5desc').style.display='block';
		document.getElementById('mapFieldsStatic').style.display='none';
		document.getElementById('mapFieldsStatic2').style.display='none';
		document.getElementById('shareWithCamp').style.display='block';
		document.getElementById('villageBlock').style.display='block';
	}
	else if (campID == -1 || campID == 0) {
		document.getElementById('mapFields1').style.display='block';
		document.getElementById('mapFields2').style.display='block';
		document.getElementById('mapFields5').style.display='none';
		document.getElementById('mapFields5desc').style.display='block';
		document.getElementById('mapFieldsStatic').style.display='none';
		document.getElementById('mapFieldsStatic2').style.display='none';
		document.getElementById('shareWithCamp').style.display='none';
		document.getElementById('villageBlock').style.display='none';
	}
	else if (campID > 0) {
		document.getElementById('campID').value=campInfo[campID][0];
		document.getElementById('addyClockID').value=campInfo[campID][3];
		document.getElementById('addyLetterID').value=campInfo[campID][4];
		if (campInfo[campID][3] != '?:??' && campInfo[campID][4] != '???') {
			document.getElementById('mapFields1').style.display='none';
			document.getElementById('mapFields2').style.display='none';
			document.getElementById('mapFields5').style.display='none';
			document.getElementById('mapFields5desc').style.display='none';
			document.getElementById('mapFieldsStatic').innerHTML="<nobr>"+campInfo[campID][6]+" set the camp address to "+campInfo[campID][3]+" & "+campInfo[campID][4]+"</nobr>";
			document.getElementById('mapFieldsStatic').style.display='block';
			document.getElementById('mapFieldsStatic2').style.display='block';
		}
		else {
			document.getElementById('mapFields1').style.display='block';
			document.getElementById('mapFields2').style.display='block';
			document.getElementById('mapFields5').style.display='none';
			document.getElementById('mapFields5desc').style.display='block';
			document.getElementById('mapFieldsStatic').style.display='none';
			document.getElementById('mapFieldsStatic2').style.display='none';
		}
		document.getElementById('shareWithCamp').style.display='block';
		document.getElementById('villageBlock').style.display='block';
	}
	if (campID == 0) document.getElementById('villageBlock').style.display='block';
	return true;
}

function displayAuto(id) {
	var idNum=1*(id);
	var campIndex=1*(campInfo[idNum][8]);
	var villageID=1*(campInfo[idNum][7]);
	//alert('word: '+word+' - id: '+id+' - campIndex: '+campIndex+'');
	document.getElementById('campID').value = campInfo[idNum][0]; // word;
	//document.getElementById('campIDid').value = id;
	loadCampInfo(idNum);
	//alert(campIndex);
	document.getElementById('campIDid').selectedIndex=campIndex;
	document.getElementById('autoCompShell').style.display='none';
	document.getElementById('campNameText').style.display='none';
	document.getElementById('campNameDrop').style.display='block';
	if (villageID > 0 && villageInfo[villageID]) {
		document.getElementById('villageIDid').selectedIndex=villageInfo[villageID][1];
		document.getElementById('villageBlock').style.display='block';
		document.getElementById('shareWithVillage').style.display='block';
	}
	else {
		document.getElementById('villageBlock').style.display='none';
		document.getElementById('shareWithVillage').style.display='none';
	}
	return true;
}

function autoBox(act) {
	if (act=='0')	document.getElementById('autoCompShell').style.display = 'none';
	else document.getElementById('autoCompShell').style.display = 'block';
	return true;
}

function changeCoords() {
	document.getElementById('mapFields1').style.display='block';
	document.getElementById('mapFields2').style.display='block';
	document.getElementById('mapFields5').style.display='none';
	document.getElementById('mapFields5desc').style.display='block';
	document.getElementById('mapFieldsStatic').style.display='none';
	document.getElementById('mapFieldsStatic2').style.display='none';
	return true;
}

function fillDivRun(searchStart) {
	searchStart = searchStart.trim();
	searchStart = searchStart.replace(/ /g, '---SPACE---');
	var url = "/autocomplete.php?content="+searchStart+"";
	//alert(url);
	$("#autoCompShell").load(url); 
	return true;
}

function clickFldNote() {
    document.getElementById('mapFields5desc').style.display='none';
    document.getElementById('mapFields5').style.display='block';
}

function clickShareVillage() {
    if (this.checked && !document.getElementById('shareWithCampmatesID').checked) {
        document.getElementById('shareWithCampmatesID').checked = true;
    }
}

function clickEditSubBtn() {
    if (document.getElementById('emailID').value == '' && !document.getElementById('burn2012ID').checked) {
        alert('Please enter your email address so we can remind you to print your map.');
        return false;
    }
    document.burnerDeets.submit();
    return true;
}

var _timer = 0;
var currSearchStart = '';
function fillDiv(searchStart) { 
	currSearchStart = searchStart;
	if (_timer) window.clearTimeout(_timer);
	_timer = window.setTimeout(function() { fillDivRun(currSearchStart); }, 1000);
}

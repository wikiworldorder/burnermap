function bodyOnScroll() {
    if (document.getElementById('headerBar')) {
        var currScroll = window.pageYOffset;
        //alert(currScroll);
        if (currScroll == 0) document.getElementById('headerBar').style.marginTop = '0px'; 
        else if (currScroll < 35) document.getElementById('headerBar').style.marginTop = '-'+currScroll+'px'; 
        else document.getElementById('headerBar').style.marginTop = '-35px';
    }
    return true;
}

var campInfo = new Array();
var villageInfo = new Array();
var plotCnt = 0;

function clearMapDeets() { 
    for (var i = 1; i <= plotCnt; i++) {
        if (document.getElementById('mapDeets'+i+'')) document.getElementById('mapDeets'+i+'').style.display='none';
    }
    return true;
}
function showDeets(cnt) {
    clearMapDeets();
    if (document.getElementById('mapDeets'+cnt+'')) {
        document.getElementById('mapDeets'+cnt+'').style.display='block';
    }
    return true;
}
function showTip(cnt) {
    if (document.getElementById('ticketTip'+cnt+'')) {
        document.getElementById('ticketTip'+cnt+'').style.display='block';
    }
    return true;
}
function hideTip(cnt) {
    if (document.getElementById('ticketTip'+cnt+'')) {
        document.getElementById('ticketTip'+cnt+'').style.display='none';
    }
    return true;
}
function randomizePlots() {
    var newZ = 10;
    for (var i = 1; i <= plotCnt; i++) {
        newZ = 9+Math.floor(Math.random()*77);
        if (newZ%2 == 1) newZ++;
        if (document.getElementById('mapPlot'+i+'')) {
            document.getElementById('mapPlot'+i+'').style.zIndex=newZ;
        }
        if (document.getElementById('mapLabel'+i+'')) {
            document.getElementById('mapLabel'+i+'').style.zIndex=(1+newZ);
        }
    }
    setTimeout("randomizePlots()", 5000);
    return true;
}
setTimeout("randomizePlots()", 5000);

function clickNotYetsMore() {
    if (!document.getElementById('absentee')) return false;
    if (document.getElementById('absentee').style.display=='none') {
        document.getElementById('absentee').style.display='block';
    } else {
        document.getElementById('absentee').style.display='none';
    }
    return true;
}
function clickNotYetsMoreMore(blockCnt) {
    if (document.getElementById('absenteeBlock'+blockCnt+'')) {
        var blockCnt2 = 1+blockCnt;
        document.getElementById('absenteeBlock'+blockCnt+'').style.display='block'; 
        if (document.getElementById('absenteeMore'+blockCnt+'')) {
            document.getElementById('absenteeMore'+blockCnt+'').style.display='none';
        }
        if (document.getElementById('absenteeMore'+blockCnt2+'')) {
            document.getElementById('absenteeMore'+blockCnt2+'').style.display='block';
        }
    }
    return true;
}

function openFBmsgWin(user) {
    window.open('https://www.facebook.com/messages/'+user+'','msg4tickets');
    return true;
}



$(document).ready(function(){
        
	$("#showJson").click(function() { $("#jsonDeets").slideToggle("fast"); });
	
	
    function toggleHidiv(fldGrp) {
        if (document.getElementById("hidiv"+fldGrp+"")) {
            if (document.getElementById("hidiv"+fldGrp+"").style.display!="block") {
                $("#hidiv"+fldGrp+"").slideDown("fast");
            } else {
                $("#hidiv"+fldGrp+"").slideUp("fast");
            }
        }
        return true;
    }
	$(document).on("click", ".hidivBtn", function() {
        var fldGrp = $(this).attr("id").replace("hidivBtn", "");
        toggleHidiv(fldGrp);
	});
	$(document).on("click", ".hidivBtnSelf", function() {
        var fldGrp = $(this).attr("id").replace("hidivBtn", "");
        toggleHidiv(fldGrp);
        $(this).slideUp("fast");
	});
	
});

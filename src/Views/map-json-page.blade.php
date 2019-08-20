<!-- map-json-page.blade.php -->
<center><div class="wBrn taL">

    <h3 class="condensed">BurnerMap Friends JSON Export</h3>
    
    <p><b>Exporting Friends to
    <a href="https://www.facebook.com/TimeToBurnApp/" target="_blank">Time To Burn</a></b></p>
    <p><b>Step 1:</b>
    <a id="copy2clip" data-clipboard-target="#jsonTextarea" href="javascript:;"
        >Copy Export to Clipboard</a>
    </p>
    <p><b>Step 2:</b>
    <a href="bmxttb://import">Import into Time To Burn</a>
    (Or just start/restart the app after copying to clipboard.)
    </p>

<p><br /></p>


    <p><b>Raw Export:</b></p>
    <textarea id="jsonTextarea" class="w100" style="height: 100px;"></textarea>
    <p><a href="javascript:;" id="downloadLink">This download</a>
    can be used to import your friends' camping info to other apps.
    You can also <nobr><a href="?listAll=1&json=1" target="_blank">click here</a></nobr>
    and use the browser to "save the page" and download the file.</p>

</div></center>
<p><br /></p>
<p><br /></p>

<div id="jsonFrame" class="disNon"></div>
<script type="text/javascript" src="/lib/clipboard.min.js"></script>
<script type="text/javascript" src="/lib/FileSaver.min.js"></script>
<script type="text/javascript">

new ClipboardJS('#copy2clip');

$(document).ready(function(){
    
    function loadJsonPage() {
        if (document.getElementById("jsonFrame").innerHTML=="") {
            $("#jsonFrame").load("/map?listAll=1&json=1");
        }
    }
    setTimeout(function() { loadJsonPage(); }, 1);

    function chkJsonTextarea() {
        if (document.getElementById("jsonFrame").innerHTML!="") {
            document.getElementById("jsonTextarea").value=document.getElementById("jsonFrame").innerHTML;
        }
        setTimeout(function() { chkJsonTextarea(); }, 3000);
    }
    setTimeout(function() { chkJsonTextarea(); }, 2000);

    $(document).on("click", "#copy2clip", function() {



        var copyText = document.getElementById("jsonTextarea");
        copyText.select();
        document.execCommand("copy");
    });

    $(document).on("click", "#downloadLink", function() {
        var jsonOut = new Blob([$("#jsonFrame").html()], {type: "text/json;charset=utf-8"});
        saveAs(jsonOut, "BurnerMap_Export_{{ date('Y-m-d') }}.json.txt");
    });
    
});
</script>

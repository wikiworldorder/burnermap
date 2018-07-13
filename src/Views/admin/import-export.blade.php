<!-- resources/views/vendor/burnermap/admin/import-export.blade.php -->
<center><div class="adminMenu adminMenuPage">

    <div class="adminHeader">Import Camps from Burning Man API</div>
    <br />
    <center><h3 class="m0">Only do this once a year!</h3></center>
    @if (trim($msg) != '') <div class="adminSpacer">{!! $msg !!}</div><hr><hr> @endif
        
    <div class="adminSpacer">
        <p>First, connect to <a href="https://api.burningman.org/api/v1/camp?year={{ date('Y') }}" target="_blank"
            >https://api.burningman.org/api/v1/camp?year={{ date('Y') }}</a> with your
            <a href="https://api.burningman.org/" target="_blank">API Key</a>. 
        Save that file to your local computer, then upload it here:</p>
        <table border=0 ><tr>
        <form name="uploadImport" action="?upload=1" method="post" enctype="multipart/form-data">
        <input type="hidden" id="csrfTok" name="_token" value="{{ csrf_token() }}">
        <td><input type="file" name="json"></td>
        <td><input type="submit" value="Upload"></td>
        </form>
        </tr></table>
    </div>
    
</div></center>
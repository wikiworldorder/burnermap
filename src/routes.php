<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {
    
    Route::post('/',            'BurnerMap\\Controllers\\OtherPages@welcomeHome');
    Route::get( '/',            'BurnerMap\\Controllers\\OtherPages@welcomeHome');
    Route::post('/welcome',     'BurnerMap\\Controllers\\OtherPages@welcomeHome');
    Route::get( '/welcome',     'BurnerMap\\Controllers\\OtherPages@welcomeHome');
    Route::get( '/welcome.php', 'BurnerMap\\Controllers\\OtherPages@welcomeHome');
    
    Route::get('/login/facebook',          'BurnerMap\\Controllers\\FaceController@redirectToProvider')
        ->middleware('guest');
    Route::get('/login/facebook/callback', 'BurnerMap\\Controllers\\FaceController@handleProviderCallback')
        ->middleware('guest');
    Route::get('/logout',                  'BurnerMap\\Controllers\\FaceController@logout');
    
    Route::post('/edit', 'BurnerMap\\Controllers\\BurnerMap@edit');
    Route::get( '/edit', 'BurnerMap\\Controllers\\BurnerMap@edit');
    
    Route::post('/map',  'BurnerMap\\Controllers\\BurnerMap@map');
    Route::get( '/map',  'BurnerMap\\Controllers\\BurnerMap@map');
    
    Route::get( '/json', 'BurnerMap\\Controllers\\BurnerMap@jsonAllCamps');
    
    Route::post('/tickets', 'BurnerMap\\Controllers\\OtherPages@tickets');
    Route::get( '/tickets', 'BurnerMap\\Controllers\\OtherPages@tickets');
    Route::get( '/tickets-instruct-have', 'BurnerMap\\Controllers\\OtherPages@ticketInstructHave');
    Route::get( '/tickets-instruct-need', 'BurnerMap\\Controllers\\OtherPages@ticketInstructNeed');
    Route::get( '/tickets-instruct-help', 'BurnerMap\\Controllers\\OtherPages@ticketInstructHelp');
    
    Route::get( '/privacy', 'BurnerMap\\Controllers\\OtherPages@privacyPage');
    
    Route::get( '/bitcoin-addy', 'BurnerMap\\Controllers\\OtherPages@bitcoinAddy');
    
    Route::get( '/admin', 'BurnerMap\\Controllers\\BurnerAdmin@dashboard');
    
    Route::post('/admin/merge-camps', 'BurnerMap\\Controllers\\BurnerAdmin@mergeCamps');
    Route::get( '/admin/merge-camps', 'BurnerMap\\Controllers\\BurnerAdmin@mergeCamps');
    
    Route::get( '/admin/check-deleted-accounts', 'BurnerMap\\Controllers\\BurnerAdmin@checkDeleted');
    
    Route::get( '/admin/new-year-archiving', 'BurnerMap\\Controllers\\AdminImportExport@newYearArchiving');
    
    Route::post('/admin/text-settings', 'BurnerMap\\Controllers\\BurnerAdmin@textSettings');
    Route::get( '/admin/text-settings', 'BurnerMap\\Controllers\\BurnerAdmin@textSettings');
    
    Route::post('/admin/import-camps-api', 'BurnerMap\\Controllers\\AdminImportExport@apiImport');
    Route::get( '/admin/import-camps-api', 'BurnerMap\\Controllers\\AdminImportExport@apiImport');
    
    Route::post('/admin/upload-maps', 'BurnerMap\\Controllers\\BurnerAdmin@uploadMaps');
    Route::get( '/admin/upload-maps', 'BurnerMap\\Controllers\\BurnerAdmin@uploadMaps');
    
    Route::post('/admin/map-tool-streets', 'BurnerMap\\Controllers\\BurnerAdmin@setKeypoints');
    Route::get( '/admin/map-tool-streets', 'BurnerMap\\Controllers\\BurnerAdmin@setKeypoints');
    
    Route::post('/admin/map-tool-misc', 'BurnerMap\\Controllers\\BurnerAdmin@setMiscPoints');
    Route::get( '/admin/map-tool-misc', 'BurnerMap\\Controllers\\BurnerAdmin@setMiscPoints');
    
    Route::get( '/admin/calculate-new-coords', 'BurnerMap\\Controllers\\BurnerAdmin@calcNewCoords');
    
    Route::get( '/admin/reassign-new-coords', 'BurnerMap\\Controllers\\BurnerAdmin@reassignNewCoords');
    
    Route::get( '/admin/show-curr-coords', 'BurnerMap\\Controllers\\BurnerAdmin@showCurrCoords');
    
    Route::get( '/admin/export-new-emails', 'BurnerMap\\Controllers\\AdminImportExport@exportNewEmails');
    
    Route::get( '/export-laravel-seeder', 'BurnerMap\\Controllers\\BurnerAdmin@exportLaravelSeeder');
    
});    

?>
<?php

// Authentication Routes...

use App\Http\Controllers\Modeli\SmallHydroelectricController;

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register-new', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register-new', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email Verification Routes...
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify'); // v5.x 
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('/', function () {
    if(Auth::check()) {
        return redirect(route('home'));
    }
    return view('auth.login');
});

/* Web Pages */
Route::group(['middleware' => ['auth','operationLog']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/home', 'HomeController@index')->name('home.index');

    Route::group(['prefix' => 'planirovanie', 'as' => 'planirovanie.'], function(){
        Route::resource('seva','Planirovanie\SevaController',['except' => ['show','create']]);
            Route::get('seva_ajax_wua', 'Planirovanie\SevaController@ajaxWua')->name('seva_ajax_wua');
            Route::get('seva_ajax_canal', 'Planirovanie\SevaController@ajaxCanal')->name('seva_ajax_canal');
        Route::resource('vodopadachi','Planirovanie\VodopadachiController',['except' => ['show','create']]);
            Route::get('vodopadachi_ajax_wua', 'Planirovanie\SevaController@ajaxWua')->name('vodopadachi_ajax_wua');
            Route::get('vodopadachi_ajax_canal', 'Planirovanie\SevaController@ajaxCanal')->name('vodopadachi_ajax_canal');
        Route::resource('vodoraspredeleniia','Planirovanie\VodoraspredeleniiaController',['except' => ['show','create']]);
            Route::get('vodoraspredeleniia_ajax_wua', 'Planirovanie\VodoraspredeleniiaController@ajaxWua')->name('vodoraspredeleniia_ajax_wua');
            Route::get('vodoraspredeleniia_ajax_canal', 'Planirovanie\VodoraspredeleniiaController@ajaxCanal')->name('vodoraspredeleniia_ajax_canal');
        Route::resource('effectivnost','Planirovanie\EffectivnostController',['except' => ['show','create']]);
            Route::get('effectivnost_ajax_wua', 'Planirovanie\SevaController@ajaxWua')->name('effectivnost_ajax_wua');
            Route::get('effectivnost_ajax_canal', 'Planirovanie\SevaController@ajaxCanal')->name('effectivnost_ajax_canal');

    });

    //>>
    // Route::group(['prefix' => 'glavnoe', 'as' => 'glavnoe.'], function(){
    //     Route::resourse('','');
    // } );
    //<<

    Route::group(['prefix' => 'vodopodacha', 'as' => 'vodopodacha.'], function(){
        Route::resource('zhurnal','Vodopodacha\ZhurnalController',['except' => ['show','create']]);
        Route::resource('akty','Vodopodacha\AktyController',['except' => ['show','create']]);
        Route::resource('vedemost','Vodopodacha\VedemostController',['except' => ['show','create']]);
    });
    
    Route::group(['prefix' => 'izmeriteli', 'as' => 'izmeriteli.','middleware' => 'allowCors'], function(){
        Route::resource('table','Izmeriteli\TableController',['except' => ['show','create']]);
        Route::resource('graph','Izmeriteli\GraphController',['except' => ['show','create']]);
    });

    Route::group(['prefix' => 'spravochnik', 'as' => 'spravochnik.'], function(){
        Route::resource('orostelnye','Spravochnik\OrostelnyeController',['except' => ['show','create']]);
        Route::resource('gidrouchastki','Spravochnik\GidrouchastkiController',['except' => ['show','create']]);
        Route::resource('gidroposty-ruchnye','Spravochnik\GidropostyRuchnyeController',['except' => ['show','create']]);
        Route::resource('gidroposty-avtomat','Spravochnik\GidropostyAvtomatController',['except' => ['show','create']]);
        Route::resource('kanaly','Spravochnik\KanalyController',['except' => ['show','create']]);
        Route::resource('polivov','Spravochnik\PolivovController',['except' => ['show','create']]);
        Route::resource('selkhozkultur','Spravochnik\SelkhozkulturController',['except' => ['show','create']]);
        Route::resource('oblasti','Spravochnik\OblastiController',['except' => ['show','create']]);
        Route::resource('raiony','Spravochnik\RaionyController',['except' => ['show','create']]);
        Route::resource('khoziaistva','Spravochnik\KhoziaistvaController',['except' => ['show','create']]);
    });

    Route::group(['prefix' => 'modeli', 'as' => 'modeli.'], function(){
        Route::resource('canal','Modeli\CanalController',['except' => ['show','create']]);
        Route::resource('catchment-area','Modeli\CatchmentAreaController',['except' => ['show','create']]);
        Route::resource('drainage','Modeli\DrainageController',['except' => ['show','create']]);
        Route::resource('hydropost','Modeli\HydropostController',['except' => ['show','create']]);
        Route::get('hydropost_ajax_wua', 'Modeli\HydropostController@ajaxWua')->name('hydropost_ajax_wua');
        Route::get('hydropost_ajax_canal', 'Modeli\HydropostController@ajaxCanal')->name('hydropost_ajax_canal');
        Route::resource('irrigation','Modeli\IrrigationController',['except' => ['show','create']]);
        Route::resource('lake','Modeli\LakeController',['except' => ['show','create']]);
        Route::resource('main-river','Modeli\MainRiverController',['except' => ['show','create']]);
        Route::resource('hydroelectric','Modeli\HydroelectricController',['except' => ['show','create']]);
        Route::resource('smallhydroelectric','Modeli\SmallHydroelectricController',['except' => ['show','create']]);
        Route::get('export-excel', 'Modeli\SmallHydroelectricController@ExportExcel')->name('smallhydroelectric_excel');
        Route::resource('oblast','Modeli\OblastController',['except' => ['show','create']]);
        Route::resource('qcordinate','Modeli\QcordinateController',['except' => ['show','create']]);
            Route::get('qcordinate_ajax_hydropost', 'Modeli\QcordinateController@ajaxHydropost')->name('qcordinate_ajax_hydropost');
            Route::get('qcordinate_ajax_canal', 'Modeli\QcordinateController@ajaxCanal')->name('qcordinate_ajax_canal');
            Route::post('qcordinate/import', 'Modeli\QcordinateController@importExcel')->name('qcordinate.import');
        Route::resource('qms','Modeli\QmsController',['except' => ['show','create']]);
            Route::get('qms_ajax_hydropost', 'Modeli\QmsController@ajaxHydropost')->name('qms_ajax_hydropost');
            Route::get('qms_ajax_canal', 'Modeli\QmsController@ajaxCanal')->name('qms_ajax_canal');
        Route::resource('qrequest','Modeli\QrequestController',['except' => ['show','create']]);
        Route::resource('qtarget','Modeli\QtargetController',['except' => ['show','create']]);
        Route::resource('qwua','Modeli\QwuaController',['except' => ['show','create']]);
            Route::get('qwua_ajax_wua', 'Modeli\QwuaController@ajaxWua')->name('qwua_ajax_wua');
            Route::get('qwua_ajax_canal', 'Modeli\QwuaController@ajaxCanal')->name('qwua_ajax_canal');
        Route::resource('region','Modeli\RegionController',['except' => ['show','create']]);
        Route::resource('reservoir','Modeli\ReservoirController',['except' => ['show','create']]);
        Route::resource('water-basin-zone','Modeli\WaterBasinZoneController',['except' => ['show','create']]);
        Route::resource('water-level','Modeli\WaterLevelController',['except' => ['show','create']]);
            Route::get('water-level_ajax_hydropost', 'Modeli\WaterLevelController@ajaxHydropost')->name('water-level_ajax_hydropost');
            Route::get('water-level_ajax_canal', 'Modeli\WaterLevelController@ajaxCanal')->name('water-level_ajax_canal');
        Route::resource('wua','Modeli\WuaController',['except' => ['show','create']]);
            Route::get('wua_ajax_canal', 'Modeli\WuaController@ajaxCanal')->name('wua_ajax_canal');

        Route::resource('user','Modeli\UserController',['except' => ['show','create']]);
        
    });


    Route::group(['prefix' => 'administrator', 'as' => 'administrator.', 'middleware' => 'isSuperAdmin'], function(){
        Route::resource('organizatsii','Administrator\OrganizatsiiController',['except' => ['show','create']]);
        Route::resource('polzovateli','Administrator\PolzovateliController',['except' => ['show','create']]);
        Route::resource('roli','Administrator\RoliController',['except' => ['show','create']]);
        Route::resource('logs','Administrator\LogsController',['except' => ['show','create']]);
    });
});

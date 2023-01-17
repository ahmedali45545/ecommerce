<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SettingController;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ */
Route::middleware('setLang')->group(function (){   
    Route::get('/lang/en', [LangController::class, 'en'])->name('lang.en');
    Route::get('/lang/ar', [LangController::class, 'ar'])->name('lang.ar'); 

    Route::group(['prefix'=>'admin','namespace' => 'Dashboard', 'middleware' => 'auth:admin'], function () {
        Route::get('/',  function (){return View('dashboard.dashboard');})->name('admin.dashboard');
        Route::get('/logout',  [LoginController::class, 'logout'])->name('admin.logout');
        Route::group(['prefix'=>'settings'],function (){
            Route::get('shipping-method/{type}',[SettingController::class, 'editShippingMethods'])->name('edit.shipping.methods');
            Route::post('shipping-method/{id}',[SettingController::class, 'updateShippingMethods'])->name('update.shipping.methods');
        });
        Route::group(['prefix'=>'profile'],function (){
            Route::get('editprofile',[ProfileController::class, 'editProfile'])->name('edit.profile');
            Route::post('updateprofile',[ProfileController::class, 'updateProfile'])->name('update.profile');
        });
    });


//Route::get('/login',  function () { return "please login";})->name('get.admin.login'); 


    Route::group(['namespace' => 'Dashboard','prefix'=>'admin','middleware' => 'guest:admin'], function () {
        Route::get('/login',  [LoginController::class, 'getLogin'])->name('get.admin.login');
        Route::post('/login',  [LoginController::class, 'login'])->name('admin.login');
        
    });
//});

});
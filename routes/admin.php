<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\LoginController;

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
Route::group(['prefix'=>'admin','namespace' => 'Dashboard', 'middleware' => 'auth:admin'], function () {
    Route::get('/',  function (){
        return View('dashboard.dashboard');
    })->name('admin.dashboard');
});


//Route::get('/login',  function () { return "please login";})->name('get.admin.login'); 


Route::group(['namespace' => 'Dashboard','prefix'=>'admin','middleware' => 'guest:admin'], function () {
    Route::get('/login',  [LoginController::class, 'getLogin'])->name('get.admin.login');
    Route::post('/login',  [LoginController::class, 'login'])->name('admin.login');
});

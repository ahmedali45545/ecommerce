<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\OptionController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\AttributeController;
use App\Http\Controllers\Dashboard\SubCategoryController;
use App\Http\Controllers\Dashboard\MainCategoryController;

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
        ///////////////////main_categories route////////////////
        Route::group(['prefix'=>'main_categories'], function () {
            Route::get('/',  [MainCategoryController::class, 'index'])->name('main_categories.index');
            Route::get('/create',  [MainCategoryController::class, 'create'])->name('main_categories.create');
            Route::post('/',  [MainCategoryController::class, 'store'])->name('main_categories.store');
            Route::get('edit/{id}',  [MainCategoryController::class, 'edit'])->name('main_categories.edit');
            Route::post('update/{id}',  [MainCategoryController::class, 'update'])->name('main_categories.update');
            Route::get('delete/{id}',  [MainCategoryController::class, 'destroy'])->name('main_categories.destroy');
        });

        ///////////////////sub_categories route////////////////
        Route::group(['prefix'=>'sub_categories'], function () {
            Route::get('/',  [SubCategoryController::class, 'index'])->name('sub_categories.index');
            Route::get('/create',  [SubCategoryController::class, 'create'])->name('sub_categories.create');
            Route::post('/',  [SubCategoryController::class, 'store'])->name('sub_categories.store');
            Route::get('edit/{id}',  [SubCategoryController::class, 'edit'])->name('sub_categories.edit');
            Route::post('update/{id}',  [SubCategoryController::class, 'update'])->name('sub_categories.update');
            Route::get('delete/{id}',  [SubCategoryController::class, 'destroy'])->name('sub_categories.destroy');
        });
        ///////////////////end sub_categories route////////////////

        ///////////////////brands route////////////////
        Route::group(['prefix'=>'brands'], function () {
            Route::get('/',  [BrandController::class, 'index'])->name('brands.index');
            Route::get('/create',  [BrandController::class, 'create'])->name('brands.create');
            Route::post('/',  [BrandController::class, 'store'])->name('brands.store');
            Route::get('edit/{id}',  [BrandController::class, 'edit'])->name('brands.edit');
            Route::post('update/{id}',  [BrandController::class, 'update'])->name('brands.update');
            Route::get('delete/{id}',  [BrandController::class, 'destroy'])->name('brands.destroy');
        });
        ///////////////////end brands route////////////////
        ///////////////////tags route////////////////
        Route::group(['prefix'=>'tags'], function () {
            Route::get('/',  [TagController::class, 'index'])->name('tags.index');
            Route::get('/create',  [TagController::class, 'create'])->name('tags.create');
            Route::post('/',  [TagController::class, 'store'])->name('tags.store');
            Route::get('edit/{id}',  [TagController::class, 'edit'])->name('tags.edit');
            Route::post('update/{id}',  [TagController::class, 'update'])->name('tags.update');
            Route::get('delete/{id}',  [TagController::class, 'destroy'])->name('tags.destroy');
        });
        ///////////////////end tags route////////////////
        ///////////////////products route////////////////
        Route::group(['prefix'=>'products'], function () {
            Route::get('/',  [ProductController::class, 'index'])->name('products.index');
            Route::get('/create',  [ProductController::class, 'create'])->name('products.create');
            Route::post('/',  [ProductController::class, 'store'])->name('products.store');
            Route::get('getPrice/{id}',  [ProductController::class, 'getPrice'])->name('products.price');
            Route::post('/storePrice',  [ProductController::class, 'storePrice'])->name('products.price.store');
            Route::get('getStock/{id}',  [ProductController::class, 'getStock'])->name('products.stock');
            Route::post('/storeStock',  [ProductController::class, 'storeStock'])->name('products.stock.store');
            Route::get('images/{id}',  [ProductController::class, 'getImages'])->name('products.images');
            Route::post('/images',  [ProductController::class, 'storeImages'])->name('products.images.store');
            //////save images to database
            Route::post('/imagesDB',  [ProductController::class, 'storeImagesDB'])->name('products.images.store.db');
            //Route::get('edit/{id}',  [ProductController::class, 'edit'])->name('products.general.edit');
            //Route::post('update/{id}',  [ProductController::class, 'update'])->name('products.update');
            //Route::get('delete/{id}',  [ProductController::class, 'destroy'])->name('products.destroy');
        });
        ///////////////////end products route////////////////
        ################################## attrributes routes ######################################
        Route::group(['prefix' => 'attributes'], function () {
            Route::get('/', [AttributeController::class,'index'])->name('attributes.index');
            Route::get('create', [AttributeController::class,'create'])->name('attributes.create');
            Route::post('store', [AttributeController::class,'store'])->name('attributes.store');
            Route::get('delete/{id}',[AttributeController::class,'destroy'])->name('attributes.delete');
            Route::get('edit/{id}', [AttributeController::class,'edit'])->name('attributes.edit');
            Route::post('update/{id}', [AttributeController::class,'update'])->name('attributes.update');
        });
        ################################## end attributes    #######################################
        ################################## options routes ######################################
        Route::group(['prefix' => 'options'], function () {
            Route::get('/', [OptionController::class,'index'])->name('options.index');
            Route::get('create', [OptionController::class,'create'])->name('options.create');
            Route::post('store', [OptionController::class,'store'])->name('options.store');
            Route::get('delete/{id}',[OptionController::class,'destroy'])->name('options.delete');
            Route::get('edit/{id}', [OptionController::class,'edit'])->name('options.edit');
            Route::post('update/{id}', [OptionController::class,'update'])->name('options.update');
        });
        ################################## end attributes    #######################################
    });
    
    ///////////////////end main_categories route////////////////

    Route::get('/test',  function () { return \App\Models\Category::first();});


    Route::group(['namespace' => 'Dashboard','prefix'=>'admin','middleware' => 'guest:admin'], function () {
        Route::get('/login',  [LoginController::class, 'getLogin'])->name('get.admin.login');
        Route::post('/login',  [LoginController::class, 'login'])->name('admin.login');
        
    });


});
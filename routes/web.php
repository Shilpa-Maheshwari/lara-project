<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeasurmentController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;

Route::get('/', [SiteController::class, 'content'])->name('content');
Route::get('/product_detailes/{id}', [SiteController::class, 'productDetailes'])->name('product');
Route::get('/loginpage',[HomeController::class, 'loginpage'])->name('loginPage');
Route::get('/register_page',[HomeController::class, 'register_view'])->name('registerPage');
Route::post('/create-account',[HomeController::class, 'createAccount'])->name('register');
Route::post('/register_page',[HomeController::class, 'singin'])->name('signin');
Route::post('/login',[HomeController::class, 'login'])->name('login');
//after login

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');


//color

Route::prefix('color')->name('color.')->group(function()
{
    Route::get('/', [ColorController::class, 'index'])->name('index');
    Route::get('create', [ColorController::class, 'create'])->name('create');
    Route::post('/store', [ColorController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ColorController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ColorController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [ColorController::class, 'destroy'])->name('destroy');

});

Route::prefix('measurment')->name('measurment.')->group(function()
{
    Route::get('/', [MeasurmentController::class, 'index'])->name('index');
    Route::get('create', [MeasurmentController::class, 'create'])->name('create');
    Route::post('/store', [MeasurmentController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [MeasurmentController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [MeasurmentController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [MeasurmentController::class, 'destroy'])->name('destroy');

});
//slider

Route::prefix('config')->name('config.')->group(function()
{
    Route::prefix('slider')->name('slider.')->group(function()
    {
        Route::get('/', [SliderController::class, 'index'])->name('index');
        Route::get('create', [SliderController::class, 'create'])->name('create');
        Route::post('/store', [SliderController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SliderController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [SliderController::class, 'destroy'])->name('destroy');

        Route::post('/update-order', [SliderController::class, 'updateSliderOrder'])->name('update-order');
    });
    Route::prefix('trending/slider')->name('trending.slider.')->group(function()
    {
        Route::get('/', [SliderController::class, 'trendingIndex'])->name('index');
        Route::get('create', [SliderController::class, 'trendingCreate'])->name('create');
        Route::post('/store', [SliderController::class, 'trendingStore'])->name('store');
        Route::get('/edit/{id}/', [SliderController::class, 'trendingEdit'])->name('edit');
        Route::put('/update/{id}', [SliderController::class, 'trendingUpdate'])->name('update');
        Route::delete('/destroy/{id}', [SliderController::class, 'trendingDestroy'])->name('destroy');
        Route::post('/update-order', [SliderController::class, 'trendingUpdateSliderOrder'])->name('update-order');
    });
});

//product add

Route::prefix('product')->name('product.')->group(function()
{
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/trash', [ProductController::class, 'trashdata'])->name('trash');
    Route::get('/restore/{id}', [ProductController::class, 'restoredata'])->name('restore');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');

});
//category Add
Route::prefix('category')->name('category.')->group(function()
{
    Route::get('/', [CategoryController::class, 'categoryIndex'])->name('index');
    Route::get('/create', [CategoryController::class, 'categoryCreate'])->name('create');
    Route::post('/store', [CategoryController::class, 'categoryStore'])->name('store');
    Route::get('/edit/{id}', [CategoryController::class, 'categoryEdit'])->name('edit');
    Route::put('/update/{id}', [CategoryController::class, 'categoryUpdate'])->name('update');
    Route::delete('/destroy/{id}', [CategoryController::class, 'categoryDestroy'])->name('destroy');
});

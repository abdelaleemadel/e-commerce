<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('redirect', [HomeController::class, "redirect"])->name('redirect')->middleware('auth');


Route::controller(ProductController::class)->group(function () {
    Route::middleware("isAdmin","auth")->group(function(){
        Route::get("products","all");
        Route::get("products/show/{id}","show");

        //Create product
        Route::get("products/create","create");
        Route::post("products","store");

        //Update product
        Route::get("products/edit/{id}","edit");
        Route::post("products/update/{id}","update");

        //Delete
        Route::post("products/delete/{id}","delete");
    });
});

Route::get("change/{lang}",function($lang){
    $lang = $lang === 'ar'?'ar':'en';

    session()->put('locale',$lang);
    app()->setLocale($lang);
    return redirect()->back();
});

<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::controller(ApiProductController::class)->group(function(){
    Route::middleware('api_auth')->group(function(){

        //Read
        Route::get("products","all");
        Route::get("products/{id}","show");

        //Create
        Route::post('products','store');

        //update
        Route::put('products/{id}',"update");
        //Delete
        Route::delete('products/{id}',"delete");
    });
});

Route::controller(ApiAuthController::class)->group(function(){
    //register
    Route::post("register","register");
    //Login
    Route::post("login","login");
    //logout
    Route::post("logout","logout");
});



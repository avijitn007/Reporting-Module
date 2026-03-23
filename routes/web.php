<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Auth\Middleware\Authenticate;
// use Illuminate\Support\Facades\Middleware;

// if(!Auth::check()){
//     // echo 'no auth';

// }


Route::get('/', function () {
    return redirect('Dashboard');
});

Route::view('login', 'login');
Route::post('authenticate-user', [Login::class, 'authenticateUser']);
Route::get('logout', [Login::class, 'logoutUser']);

Route::view('registration', 'registration');
Route::post('sign-up', [Users::class, 'register']);
Route::view('reset-password', 'reset-password');
Route::post('new-password', [Users::class, 'newPassword']);
Route::get('session', [Login::class, 'session']);

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('users', [Users::class, 'index']);
        Route::post('update-role/{id}', [Users::class, 'updateRole']);
        Route::post('deactivate-user/{id}', [Users::class, 'deactivate']);
    });

    Route::get('/Dashboard', [Dashboard::class, 'index']);

    Route::get('affiliates', [Affiliates::class, 'index']);
    Route::post('add-affiliate', [Affiliates::class, 'add']);
    Route::get('edit-affiliate/{id}', [Affiliates::class, 'edit']);
    Route::put('update-affiliate/{affiliate}',[Affiliates::class, 'update']);
    Route::get('deactivate-affiliate/{id}', [Affiliates::class, 'deactivate']);
    Route::get('activate-affiliate/{id}', [Affiliates::class, 'activate']);

    // Route::get('campaigns', [Campaigns::class, 'index']);
    Route::post('add-campaigns', [Campaigns::class,'add']);
    Route::get('campaigns', [Campaigns::class, 'edit']);
    Route::post('update-campaigns', [Campaigns::class,'update']);
    Route::get('deactivate-campaign/{id}', [Campaigns::class,'deactivate']);
    Route::get('activate-campaign/{id}', [Campaigns::class,'activate']);
    Route::post('remove-campaign', [Campaigns::class, 'remove']);

});

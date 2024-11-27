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
Route::post('sign-up', [Dashboard::class, 'register']);
Route::get('session', [Login::class, 'session']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('users', [Dashboard::class, 'users']);
    Route::get('/Dashboard', [Dashboard::class, 'index']);

    Route::get('affiliates', [Affiliates::class, 'index']);
    Route::post('add-affiliate', [Affiliates::class, 'add']);
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

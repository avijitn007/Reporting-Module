<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;


// if(!Auth::check()){
//     // echo 'no auth';
// }


use App\Http\Controllers\PasswordResetController;

Route::middleware('guest')->group(function () {
    Route::view('/forgot-password', 'forgot-password');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password', function () {
        return view('reset-password', ['token' =>  request('token'), 'email' => request('email')]);
    })->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::get('/', function () {
    return redirect('Dashboard');
});

Route::view('login', 'login')->name('login');
Route::post('authenticate-user', [Login::class, 'authenticateUser']);
Route::get('logout', [Login::class, 'logoutUser']);

Route::view('registration', 'registration');
Route::post('sign-up', [Users::class, 'register']);
// Route::view('forgot-password', 'forgot-password');
// Route::post('forgot-password', [Users::class, 'sendResetLink']);

// Route::view('reset-password', 'reset-password');
// Route::post('new-password', [Users::class, 'newPassword']);
Route::get('session', [Login::class, 'session']);

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('users', [Users::class, 'index']);
        Route::post('update-role/{id}', [Users::class, 'updateRole']);
        Route::get('deactivate-user/{id}', [Users::class, 'deactivate']);
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


    Route::get('profile', [Users::class, 'profile']);
    Route::post('update-profile', [Users::class, 'updateProfile']);

});

<?php

use App\Http\Livewire\Frontpage;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Verify email routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Dashboard routes
Route::group(['middleware' => [
    'auth:sanctum',
    'verified',
    'access.role',
]], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/pages', function () {
        return view('admin.pages');
    })->name('pages');

    Route::get('/navigation-menus', function () {
        return view('admin.navigation-menus');
    })->name('navigation-menus');
});

Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware('verified')->name('profile');

// Blog routes
Route::get('/{urlslug}', Frontpage::class);
Route::get('/', Frontpage::class);

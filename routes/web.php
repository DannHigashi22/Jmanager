<?php

use RealRashid\SweetAlert\Facades\Alert;

//verify
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ErrorController;

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

Route::get('/', function () {
    return view('welcome');
})->name('/');

Auth::routes(['register' => false]);


//verify
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    smilify('Bienvenido! 🔥 ', 'Email verificado');
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('resent', 'Link de verificacion enviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('audits/export',[AuditController::class,'exportAudits'])->name('exportAudits')->middleware('auth','verified','checkuseractive');
Route::group(['middleware' => ['auth', 'verified','checkuseractive']], function () {
    //dashboard
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('roles', RolController::class);
    Route::resource('users', UserController::class);
    Route::resource('audits', AuditController::class);
    Route::post('audits/import',[AuditController::class,'importShoppers'])->name('importShoppers');
    
    Route::resource('errors', ErrorController::class);
});

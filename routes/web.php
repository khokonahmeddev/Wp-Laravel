<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('migrate', function () {
    Artisan::call('migrate');
});

Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/comment/{id}', [HomeController::class, 'comment'])->name('comment.view');
Route::post('/comment-store/{id}', [HomeController::class, 'commentStore'])->name('comment.store');
Route::get('change-password', [HomeController::class, 'changePassword'])->name('change.password');
Route::post('confirm-password', [HomeController::class, 'confirmPassword'])->name('password.update');

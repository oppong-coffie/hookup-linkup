<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServerController;

Route::get('/', [ServerController::class, 'index'])->name('home');
Route::get('/detail/{id}', [ServerController::class, 'show'])->name('detail.show');
Route::get('/server/{id}', [ServerController::class, 'show'])->name('server.show');

Route::post('/detail/{id}/like', [ServerController::class, 'like'])->name('detail.like');
Route::post('/server/{id}/like', [ServerController::class, 'like']);
Route::post('/detail/{id}/comment', [ServerController::class, 'addComment'])->name('detail.comment');
Route::post('/server/{id}/comment', [ServerController::class, 'addComment']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::get('/portal', function () {
        return view('portal');
    });

    Route::get('/portal/edit', function () {
        return view('auth.editportal');
    });

    Route::put('/portal/edit', [AuthController::class, 'updateProfile']);

    Route::post('/portal/gallery', [AuthController::class, 'updateGallery']);
    Route::delete('/portal/gallery', [AuthController::class, 'deleteGallery']);
});
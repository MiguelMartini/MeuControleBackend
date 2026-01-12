<?php

use App\Http\Controllers\API\CardController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::patch('/update', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'destroy']);

    Route::get('/cards', [CardController::class, 'index'])->name('card.index');
    Route::get('/card/{id}', [CardController::class, 'show'])->name('card.show');
    Route::post('/cards/store', [CardController::class, 'store'])->name('card.store');
});

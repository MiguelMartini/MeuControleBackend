<?php

use App\Http\Controllers\API\BillController;
use App\Http\Controllers\API\CardController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::patch('/update', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'destroy']);

    Route::get('/cards', [CardController::class, 'index'])->name('card.index');
    Route::get('/card/{id}', [CardController::class, 'show'])->name('card.show');
    Route::post('/cards/store', [CardController::class, 'store'])->name('card.store');
    Route::delete('/delete/card/{id}', [CardController::class, 'destroy'])->name('card.destroy');
    Route::patch('/update/card/{id}', [CardController::class, 'update'])->name('card.update');


    Route::get('/bills', [BillController::class, 'index'])->name('bill.index');

    Route::post('/bill', [BillController::class, 'store']) ->name('bill.store');
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\bidsController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\RacesController;
use App\Http\Controllers\GiftCoinController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WithdrawController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [userController::class, 'register']);

Route::post('reset-password-admin', [userController::class, 'setPasswordForUser']);
Route::post('/forget-password', [userController::class, 'forgetPassword']);

Route::post('login', [userController::class, 'login']);
Route::get('check-user-balance', [userController::class, 'checkBalance']);
Route::post('add-coins', [userController::class, 'addCoins']);

Route::get('get-users', [userController::class, 'getAllUsers']);

Route::post('/bids', [bidsController::class, 'store']);

Route::post('/bid-winner', [bidsController::class, 'bidWinner']);

Route::post('/bids/check-user-bids', [bidsController::class, 'checkUser']);

Route::post('/available_coins', [GiftCoinController::class, 'store']);


// STORE RACE
Route::post('/races', [RacesController::class, 'store']);

Route::get('/check-race', [RacesController::class, 'checkRaceAvailability']);

Route::post('/add-admin-coins', [userController::class, 'addAdminCoins']);
Route::post('/remove-prev-bids', [RacesController::class, 'removePrevBids']);
Route::get('/fetch-hour-bids', [RacesController::class, 'fetchBids']);
Route::get('/update-horse-id', [RacesController::class, 'updateHorseId']);
Route::get('/git-coins', [GiftCoinController::class, 'returnGiftCoins']);
Route::get('/check-update', [GiftCoinController::class, 'checkUpdate']);

Route::post('settings/{key}', [SettingsController::class, 'update']);
Route::get('settings/{key}', [SettingsController::class, 'retrieve']);


Route::get('/withdraws', [WithdrawController::class, 'index']);
Route::post('/withdraws', [WithdrawController::class, 'store']);
Route::get('/withdraws/{withdraw}', [WithdrawController::class, 'show']);
Route::post('/withdraws/{withdraw}', [WithdrawController::class, 'update']);
Route::post('/withdraws/{withdraw}', [WithdrawController::class, 'destroy']);

Route::get('/deposits', [DepositController::class, 'index']);
Route::post('/deposits', [DepositController::class, 'store']);
Route::get('/deposits/{deposit}', [DepositController::class, 'show']);
Route::put('/deposits/{deposit}', [DepositController::class, 'update']);
Route::delete('/deposits/{deposit}', [DepositController::class, 'destroy']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [userController::class, 'logout']);
});

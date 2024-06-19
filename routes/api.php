<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\Api\FoodController;

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

Route::post('/payments', [PaymentController::class, 'create'])->name('api.payments');

Route::post('/payments/webhook', [PaymentController::class, 'webhook'])->name('api.payments.webhook');

Route::controller(ToolController::class)->group(function () {
    // member
    Route::post('/tool/searchAds', 'searchAds')->name('tool.searchAds');
    Route::post('/tool/showDistirct', 'showDistirct')->name('tool.showDistirct');

});
Route::post('/send-whatsapp', [WhatsAppController::class, 'send']);
Route::controller(FoodController::class)->prefix('/food')->name('food.')->group(function () {
    // listing food
    Route::get('/', 'listing')->name('listing');

});

<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create-token', [TokenController::class, 'createToken'] );
Route::get('/flight/search', [SearchController::class, 'search'] );
Route::get('/flight/fare-rules', [SearchController::class, 'getFareRules'] );
Route::get('/flight/price', [PriceController::class, 'price'] );
Route::put('/flight/save-travelers', [PriceController::class, 'saveTraveler'] );
Route::post('/flight/book', [BookController::class, 'book'] );
Route::post('/flight/ticket', [TicketController::class, 'ticket'] );
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ContactController;
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

Route::apiResource('contacts', ContactController::class);

Route::put('/contacts/{id}', [ContactController::class, 'update']);
Route::post('/contacts/search', [ContactController::class, 'search'])->name('contacts.search');
Route::post('/contacts/phone', [ContactController::class, 'phone'])->name('contacts.phone');
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);

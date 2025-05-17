<?php

use App\Http\Controllers\API\PosterController;
use App\Http\Controllers\APIController;
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

// API tp send emails
Route::post('/sendMail', [APIController::class, 'sendMail']);

// API to get the token
Route::get('/token', [APIController::class, 'getToken']);

// API to get the events' details
Route::get('/posters', [PosterController::class, 'index']);


// Route::get('/test', function () {
//     return response()->json(['status' => 'ok']);
// });

<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;


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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/registrasi', [AuthController::class, 'registration']);

Route::middleware('auth:sanctum')->resource('/album', AlbumController::class)->names('album');
Route::middleware('auth:sanctum')->resource('/foto', FotoController::class)->names('foto');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Logged out successfully']);
});

Route::middleware('auth:sanctum')->get('/hello-world', function () {
    return response()->json(['message' => 'Hello, World!']);
});


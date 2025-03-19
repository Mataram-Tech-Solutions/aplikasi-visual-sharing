<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Carbon\Carbon;

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
Route::post('/registrasi', [AuthController::class, 'regis']);

Route::middleware('auth:sanctum')->resource('/album', AlbumController::class)->names('album');
Route::middleware('auth:sanctum')->resource('/foto', FotoController::class)->names('foto');
Route::middleware('auth:sanctum')->resource('/like', LikeController::class)->names('like');
Route::middleware('auth:sanctum')->resource('/comment', KomentarController::class)->names('comment');
Route::middleware('auth:sanctum')->resource('/profile', ProfileController::class)->names('profile');
Route::middleware('auth:sanctum')->post('/search-user', [SearchController::class, 'searchUser'])->name('searchUser');

//home page
Route::middleware('auth:sanctum')->get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    return response()->json([
        'status' => true,
        'message' => 'Data user ditemukan!',
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'foto' => $user->foto,
            'alamat' => $user->alamat,
            'created_at' => Carbon::parse($user->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($user->updated_at)->format('Y-m-d H:i:s'),
        ]
    ], 200);
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Logged out successfully']);
});

Route::middleware('auth:sanctum')->get('/hello-world', function () {
    return response()->json(['message' => 'Hello, World!']);
});


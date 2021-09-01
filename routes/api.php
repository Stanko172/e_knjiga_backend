<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/register", [RegisterController::class, 'register']);
Route::post("/login", [LoginController::class, 'login']);
Route::post("/logout", [LoginController::class, 'logout']);

Route::get("/abilities", [App\Http\Controllers\AbilitiesController::class, 'index']);

//Admin panel API routes
Route::prefix('admin')->group(function(){
    Route::post("/user_membership_card/create", [App\Http\Controllers\UserMembershipController::class, 'create']);
    Route::post("/user_membership_card/store", [App\Http\Controllers\UserMembershipController::class, 'store']);
    Route::delete("/user_membership_card/delete", [App\Http\Controllers\UserMembershipController::class, 'delete']);
    Route::delete("/user_membership_card/destroy", [App\Http\Controllers\UserMembershipController::class, 'destroy']);
});

//User panel API routes
Route::prefix('user')->group(function(){
    Route::post("/membership_request/create", [App\Http\Controllers\MembershipRequestController::class, 'create']);
});

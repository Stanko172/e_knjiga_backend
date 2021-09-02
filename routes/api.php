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

Route::patch("/otpassword_change", [LoginController::class, 'otpassword_change']);

Route::get("/abilities", [App\Http\Controllers\AbilitiesController::class, 'index']);

//Admin panel API routes
Route::prefix('admin')->group(function(){
    //User membership card
    Route::post("/user_membership_card/create", [App\Http\Controllers\UserMembershipController::class, 'create']);
    Route::delete("/user_membership_card/delete", [App\Http\Controllers\UserMembershipController::class, 'delete']);

    //Membership request
    Route::get("/membership_request/index", [App\Http\Controllers\MembershipRequestController::class, 'index']);
    Route::post("/membership_request/store", [App\Http\Controllers\MembershipRequestController::class, 'store']);
    Route::post("/membership_request/delete", [App\Http\Controllers\MembershipRequestController::class, 'delete']);
});

//User panel API routes
Route::prefix('user')->group(function(){
    Route::post("/membership_request/create", [App\Http\Controllers\MembershipRequestController::class, 'create']);
});

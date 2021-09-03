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
    //Permission
    Route::get("/permission/index", [App\Http\Controllers\admin\PermissionController::class, 'index']);
    Route::post("/permission/save", [App\Http\Controllers\admin\PermissionController::class, 'save']);
    Route::delete("/permission/delete/{id}", [App\Http\Controllers\admin\PermissionController::class, 'delete']);

    //Role
    Route::get("/role/index", [App\Http\Controllers\admin\RoleController::class, 'index']);
    Route::post("/role/create", [App\Http\Controllers\admin\RoleController::class, 'create']);
    Route::post("/role/edit", [App\Http\Controllers\admin\RoleController::class, 'edit']);
    Route::delete("/role/delete/{id}", [App\Http\Controllers\admin\RoleController::class, 'delete']);

    //User
    Route::get("/user/index", [App\Http\Controllers\admin\UserController::class, 'index']);
    Route::post("/user/create", [App\Http\Controllers\admin\UserController::class, 'create']);
    Route::post("/user/edit", [App\Http\Controllers\admin\UserController::class, 'edit']);
    Route::delete("/user/delete/{id}", [App\Http\Controllers\admin\UserController::class, 'delete']);

    //User membership card
    Route::post("/user_membership_card/create", [App\Http\Controllers\admin\UserMembershipController::class, 'create']);
    Route::delete("/user_membership_card/delete", [App\Http\Controllers\admin\UserMembershipController::class, 'delete']);

    //Membership request
    Route::get("/membership_request/index", [App\Http\Controllers\admin\MembershipRequestController::class, 'index']);
    Route::post("/membership_request/store", [App\Http\Controllers\admin\MembershipRequestController::class, 'store']);
    Route::post("/membership_request/delete", [App\Http\Controllers\admin\MembershipRequestController::class, 'delete']);

    //Book
    Route::get("/book/index", [App\Http\Controllers\BookController::class, 'index']);
    Route::post("/book/update/{id}", [App\Http\Controllers\BookController::class, 'update']);
    Route::post("/book/delete/{id}", [App\Http\Controllers\BookController::class, 'destroy']);
    Route::post("/book/create", [App\Http\Controllers\BookController::class, 'create']);

    //Genre
    Route::get("/genre/index", [App\Http\Controllers\GenreController::class, "index"]);
    Route::post("/genre/update/{id}", [App\Http\Controllers\GenreController::class, 'update']);
    Route::post("/genre/delete/{id}", [App\Http\Controllers\GenreController::class, 'destroy']);
    Route::post("/genre/create", [App\Http\Controllers\GenreController::class, 'create']);

    //Writer
    Route::get("/writer/index", [App\Http\Controllers\WriterContorller::class, "index"]);
    Route::post("/writer/update/{id}", [App\Http\Controllers\WriterContorller::class, 'update']);
    Route::post("/writer/delete/{id}", [App\Http\Controllers\WriterContorller::class, 'destroy']);
    Route::post("/writer/create", [App\Http\Controllers\WriterContorller::class, 'create']);

    //Book
    Route::get("/ebook/index", [App\Http\Controllers\EbookController::class, 'index']);
    Route::post("/ebook/update/{id}", [App\Http\Controllers\EbookController::class, 'update']);
    Route::post("/ebook/delete/{id}", [App\Http\Controllers\EbookController::class, 'destroy']);
    Route::post("/ebook/create", [App\Http\Controllers\EbookController::class, 'create']);
});

//User panel API routes
Route::prefix('user')->group(function(){
    Route::post("/membership_request/create", [App\Http\Controllers\MembershipRequestController::class, 'create']);
    Route::get("/shop_office/index", [App\Http\Controllers\ShopOfficeController::class, 'index']);
});

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

Route::post("forgot-password", [App\Http\Controllers\NewPasswordController::class, 'forgot']);
Route::post("reset-password", [App\Http\Controllers\NewPasswordController::class, 'reset']);

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

    //EBook
    Route::get("/ebook/index", [App\Http\Controllers\EbookController::class, 'index']);
    Route::post("/ebook/update/{id}", [App\Http\Controllers\EbookController::class, 'update']);
    Route::post("/ebook/delete/{id}", [App\Http\Controllers\EbookController::class, 'destroy']);
    Route::post("/ebook/create", [App\Http\Controllers\EbookController::class, 'create']);

    //Rental request
    Route::get("/rental_request/index", [App\Http\Controllers\admin\RentalRequestController::class, 'index']);
    Route::post("/rental_request/create", [App\Http\Controllers\admin\RentalRequestController::class, 'create']);
    Route::post("/rental_request/delete", [App\Http\Controllers\admin\RentalRequestController::class, 'delete']);

    //Rental
    Route::get("/rental/index", [App\Http\Controllers\admin\RentalRequestConfirmedController::class, 'index']);
    Route::patch("/rental/picked_up/{id}", [App\Http\Controllers\admin\RentalRequestConfirmedController::class, 'picked_up']);
    Route::patch("/rental/returned/{id}", [App\Http\Controllers\admin\RentalRequestConfirmedController::class, 'returned']);

});

//User panel API routes
Route::prefix('user')->group(function(){
    Route::post("/membership_request/create", [App\Http\Controllers\MembershipRequestController::class, 'create']);
    Route::get("/shop_office/index", [App\Http\Controllers\ShopOfficeController::class, 'index']);

    //Writer
    Route::get("/writer/index", [App\Http\Controllers\user\WriterController::class, 'index']);

    //Genre
    Route::get("/genre/index", [App\Http\Controllers\user\GenreController::class, 'index']);

    //Dashboard
    Route::post("/dashboard/books", [App\Http\Controllers\user\BookController::class, 'index']);
    Route::post("/dashboard/ebooks", [App\Http\Controllers\user\EBookController::class, 'index']);

    Route::post("/purchase/book", [App\Http\Controllers\UserController::class, 'purchase_book']);
    Route::post("/purchase/membership", [App\Http\Controllers\UserController::class, 'purchase_membership']);

    Route::post("/coupons/{id}", [App\Http\Controllers\CouponController::class, 'index']);

    //Book
    Route::get("/book/{id}", [App\Http\Controllers\user\BookController::class, 'show']);

    //Book rating
    Route::post("/book_rating/save", [App\Http\Controllers\user\BookRatingController::class, 'create']);

    //Book rental request
    Route::post("/rental_request/create", [App\Http\Controllers\user\RentalRequestsController::class, 'create']);

    //Ebook
    Route::get("/ebook/{id}", [App\Http\Controllers\user\EBookController::class, 'show']);

    //Book rating
    Route::post("/ebook_rating/save", [App\Http\Controllers\user\EBookRatingController::class, 'create']);

    //User activities
    Route::get("/activity/index", [App\Http\Controllers\user\ActivitiesController::class, 'index']);
});

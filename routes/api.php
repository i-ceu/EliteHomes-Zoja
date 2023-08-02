<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    BookingController,
    UserController,
    PropertyController,
    CategoryController,
    FavouriteController,
    ReviewsController
};






use App\Http\Middleware\{CheckOwnerShipMiddleware, CheckPropertyOwner, FavOwner, UserFav, ReviewsOwner};

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


Route::prefix('v1')->group(function () {


    /// Declare the heartbeat route for the API
    Route::any('/', function () {
        return response()->json(['message' => 'Welcome to Elite Homes API'], 200);
    });

    // Declare register route
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    // Declare login route
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    //All Unprotected routes should be declared here.
    Route::post('forgetpassword', [AuthController::class, 'forgetPassword'])->name('forgetPassword');
    Route::post('passwordReset', [AuthController::class, 'passwordReset']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('no-auth-user-show');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
    Route::get('/properties/{property}/reviews', [ReviewsController::class, 'index'])->name('get-all-reviews');




    //Protected routes for authenticated users
    Route::group(['middleware'  => ['auth:api']], static function () {


        //PROPERTY ROUTES
        Route::prefix('properties')->group(function () {
            Route::group(['middleware' => [CheckPropertyOwner::class]], static function () {
                Route::put('/{property}', [PropertyController::class, 'update'])->name('properties.update');
                //route for user to delete a product
                Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
                Route::get('/{property}/bookings', [BookingController::class, 'showAllPropertyEnquiries'])->name('show-all-property-enquiries');
            });

            Route::get('/{property}/user/', [PropertyController::class, 'getOwnerDetails'])->name('properties.getOwnerDetails');
        });



        //BOOKING ROUTES
        Route::post('/booking', [BookingController::class, 'store'])->name('create-booking');
        Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('show-booking');

        //CATEGORY ROUTES
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('no-admin-index');
            Route::get('/{category}', [CategoryController::class, 'show'])->name('no-admin-show');
        });

        //FAVOURITE ROUTES

        Route::prefix('favourites')->group(function () {
            Route::get('/{userId}/properties', [FavouriteController::class, 'index'])->name('favourite.index');
            Route::post('/{propertyId}', [FavouriteController::class, 'store'])->name('favourite.store');
            Route::delete('/{propertyId}', [FavouriteController::class, 'delete'])->name('favourite.delete');
            Route::get('/{userId}/{propertyId}/check', [FavouriteController::class, 'checkFavourite'])->name('favourite.checkFavourite');
        });


        //PROPERTY ROUTES
        Route::prefix('properties')->group(function () {
            Route::group(['middleware' => [CheckPropertyOwner::class]], static function () {
                Route::put('/{property}', [PropertyController::class, 'update'])->name('properties.update');
                //
                Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
                Route::get('/{property}/bookings', [BookingController::class, 'showAllPropertyEnquiries'])->name('show-all-property-enquiries');
            });

            Route::group(['middleware' => ['role:is_landlord']], static function () {
                //route for user to store a product
                Route::post('/', [PropertyController::class, 'store'])->name('properties.store');
            });
        });


        //REVIEWS
Route::group(['middleware' => [ReviewsOwner::class]], function (){
    
    Route::put('/properties/reviews/{review}', [ReviewsController::class, 'update']);
    Route::delete('/properties/reviews/{review}', [ReviewsController::class, 'destroy']);
});
        Route::post('/properties/reviews', [ReviewsController::class, 'store']);


        // ADMIN ROUTES
        Route::prefix('admin')->middleware(['role:is_admin'])->group(function () {
            Route::apiResource('/categories', CategoryController::class)->name('Admin', 'Categories');
            Route::apiResource('/users', UserController::class)->name('Admin', 'users');
        });

        //USR ROUTES
        Route::group(['prefix' => 'users'],  static function () {
            Route::get('/{id}/reviews', [UserController::class, 'reviews'])->name('users.reviews');

            Route::group(['middleware' => [CheckOwnerShipMiddleware::class]], static function () {
                Route::put('/{id}', [UserController::class, 'update'])->name('user-update-self');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('users-delete-self');

                Route::get('/{id}/bookings', [BookingController::class, 'showAllUserEnquiries'])->name('show-user-bookings');
            });

            Route::get('/{id}/properties', [PropertyController::class, 'userindex'])->name('properties.userindex');
        });
    });
});

<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    BookingController,
    UserController,
    PropertyController,
    CategoryController,
    FavouriteController
};
use App\Http\Middleware\{CheckOwnerShipMiddleware, CheckPropertyOwner, FavOwner, UserFav};

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
    Route::get('/users/{id}', [UserController::class, 'show'])->name('no-auth-user-show');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::get('/', [PropertyController::class, 'index'])->name('properties.index');

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

            Route::get('properties/{property}/user/', [PropertyController::class, 'getOwnerDetails'])->name('properties.getOwnerDetails');
        });



        //BOOKING ROUTES
        Route::apiResource('/booking', BookingController::class);

        //CATEGORY ROUTES
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('no-admin-index');
            Route::get('/{category}', [CategoryController::class, 'show'])->name('no-admin-show');

            Route::group(['middleware' => [UserFav::class]], static function () {
                Route::get('/user/favourites', [FavouriteController::class, 'index'])->name('favourite.index');
            });
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

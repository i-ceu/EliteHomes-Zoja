<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    BookingController,
    UserController,
    PropertyController,
    CategoryController
};
use App\Http\Middleware\{AdminMiddleware, CheckOwnerShipMiddleware, CheckPropertyOwner, IsLandlord};

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

    //Route for user to get all properties
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');


    //route for user to update a product
    Route::get('/properties/{property}', [PropertyController::class, 'show']);

    //All Unprotected routes should be declared here.
    Route::post('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');

    //Route for user to get all properties
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    //route for user to update a product
    Route::get('/properties/{property}', [PropertyController::class, 'show']);

    Route::apiResource('categories', CategoryController::class);

    //Protected routes for authenticated users
    Route::group(['middleware'  => ['auth:api']], static function () {

        Route::group(['middleware' => [IsLandlord::class]], static function () {
            //route for user to store a product
            Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
        });
        Route::group(['middleware' => [CheckPropertyOwner::class]], static function () {
            Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
            //route for user to delete a product
            Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
        });

        Route::get('/categories', [CategoryController::class, 'index'])->name('no-admin-index');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('no-admin-show');

        Route::apiResource('/booking', BookingController::class);
        // All Admin routes should be declared here
        Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {
            Route::apiResource('/categories', CategoryController::class)->name('Admin', 'Categories');
            Route::apiResource('/users', UserController::class)->name('Admin', 'Users');
            Route::apiResource('categories', CategoryController::class)->name('Admin', 'categories');
        });

        Route::group(['prefix' => 'users'],  static function () {
            Route::get('/{id}/reviews', [UserController::class, 'reviews'])->name('users.reviews');

            Route::group(['middleware' => [CheckOwnerShipMiddleware::class]], static function () {
                Route::put('/{id}', [UserController::class, 'update'])->name('user-update-self');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('users-delete-self');
            });
        });
    });
});

<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    UserController,
    PropertyController,
    CategoryController
};
use App\Http\Middleware\{AdminMiddleware, CheckOwnerShipMiddleware, IsLandlord};

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
    //route for user to view one product via id
    //Route::post('/properties/{id}', [ProductController::class, 'show']);
    //route for user to store a product
    //Route::post('/properties',[ProductController::class, 'store']);
    //route for user to update a product
    //Route::put('/products{id}', [ProductController::class, 'update']);
    //route for user to delete a product
    //Route::delete('/properties{id}',[ProductController::class, 'destroy']);

    Route::get('/properties/{property}', [PropertyController::class, 'show']);

    Route::group(['middleware' => [IsLandlord::class]], static function () {
        //route for user to store a product
        Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
        //route for user to update a product
        Route::put('/properties{id}', [PropertyController::class, 'update'])->name('properties.update');
        //route for user to delete a product
        Route::delete('/properties{id}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    });
    //All Unprotected routes should be declared here.
    Route::post('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');



    //Protected routes for authenticated users
    Route::group(['middleware'  => ['auth:api']], static function () {

        // All Admin routes should be declared here
        Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {
            Route::apiResource('/users', UserController::class)->name('Admin', 'Users');
            Route::apiResource('categories', CategoryController::class);
        });

        Route::group(['prefix' => 'users'],  static function () {
            Route::get('/{id}/reviews', [UserController::class, 'reviews'])->name('users.reviews');

            Route::group(['middleware' => [CheckOwnerShipMiddleware::class]], static function () {
                Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
            });
        });
    });
});

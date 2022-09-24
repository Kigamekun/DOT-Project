<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{OrdersController,ItemsController,AuthController};

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




Route::prefix('v1')->group(function () {
    //API route for register new user
    Route::post('/register', [AuthController::class, 'register']);
    //API route for login user
    Route::post('/login', [AuthController::class, 'login']);


    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrdersController::class,'index'])->name('api.orders.index');
            Route::post('/store', [OrdersController::class,'store'])->name('api.orders.store');
            Route::put('/update/{id}', [OrdersController::class,'update'])->name('api.orders.update');
            Route::delete('/delete/{id}', [OrdersController::class,'destroy'])->name('api.orders.delete');
        });


        Route::prefix('items')->group(function () {
            Route::get('/', [ItemsController::class,'index'])->name('api.items.index');
            Route::post('/store', [ItemsController::class,'store'])->name('api.items.store');
            Route::put('/update/{id}', [ItemsController::class,'update'])->name('api.items.update');
            Route::delete('/delete/{id}', [ItemsController::class,'destroy'])->name('api.items.delete');
        });

        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

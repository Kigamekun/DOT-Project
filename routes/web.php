<?php

use Illuminate\Support\Facades\Route;
use App\Models\{Order,Item};
use App\Http\Controllers\{OrdersController,ItemsController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $order = Order::all();
        return view('dashboard', ['order'=>$order]);
    })->name('dashboard');


    Route::prefix('orders')->group(function () {
        Route::get('/', [OrdersController::class,'index'])->name('orders.index');
        Route::post('/store', [OrdersController::class,'store'])->name('orders.store');
        Route::patch('/update/{id}', [OrdersController::class,'update'])->name('orders.update');
        Route::delete('/delete/{id}', [OrdersController::class,'destroy'])->name('orders.delete');
    });


    Route::prefix('items')->group(function () {
        Route::get('/', [ItemsController::class,'index'])->name('items.index');
        Route::post('/store', [ItemsController::class,'store'])->name('items.store');
        Route::patch('/update/{id}', [ItemsController::class,'update'])->name('items.update');
        Route::delete('/delete/{id}', [ItemsController::class,'destroy'])->name('items.delete');
    });
});



require __DIR__.'/auth.php';

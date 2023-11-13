<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class,'index']);
Route::Post('/logouts',[HomeController::class,'logout'])->name('logouts');
Route::get('/categories',[CategoryController::class,'index'])->name('categories');
Route::post('/category/store',[CategoryController::class,'store'])->name('categories_store');
Route::post('/category/update/{id}',[CategoryController::class,'update'])->name('categories_update');
Route::get('/category/edit/{id}',[CategoryController::class,'edit'])->name('categories_edit');





Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/redirect',[HomeController::class,'redirect'])->name('dashboard');

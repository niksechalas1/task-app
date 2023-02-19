<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.new');

Route::get('/tasks/all', [App\Http\Controllers\TaskController::class, 'all'])->name('all.tasks');
Route::post('/tasks/store', [App\Http\Controllers\TaskController::class, 'store'])->name('store.tasks');
Route::post('/tasks/update/{id}', [App\Http\Controllers\TaskController::class, 'update'])->name('update.tasks');
Route::delete('/tasks/delete/{id}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('delete.tasks');

Route::get('/users/show', [App\Http\Controllers\UserController::class, 'show'])->name('show.profile');
Route::post('/users/update', [App\Http\Controllers\UserController::class, 'update'])->name('update.profile');

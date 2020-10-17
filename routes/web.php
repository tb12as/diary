<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\User\DiaryController;
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

Route::middleware('auth')->group(function() {
	Route::resource('diary', DiaryController::class)->except(['edit', 'update', 'create', 'show']);
	Route::get('diary/{diary}', [DiaryController::class, 'show'])->name('diary.show')->middleware('isOwner');

	Route::middleware('isAdmin')->prefix('admin')->group(function() {
		Route::get('user', [UserManagementController::class, 'index'])->name('userman.index');
		Route::get('user/{user}', [UserManagementController::class, 'show'])->name('userman.show');
		Route::put('user/{user}', [UserManagementController::class, 'destroy'])->name('userman.destroy');
		// admin
		Route::get('admin', [AdminManagementController::class, 'index'])->name('adminman.index');
		Route::post('admin', [AdminManagementController::class, 'store'])->name('adminman.store');
		Route::get('admin/{id}', [AdminManagementController::class, 'show'])->name('adminman.show');
		Route::put('admin/{id}', [AdminManagementController::class, 'destroy'])->name('adminman.destroy');
	});
});

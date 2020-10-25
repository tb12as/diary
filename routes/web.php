<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\User\DiaryController;
use App\Http\Controllers\User\SettingController;
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

	Route::prefix('setting')->group(function() {
		Route::get('/', [SettingController::class, 'index'])->name('settings');
		Route::post('/', [SettingController::class, 'save'])->name('settings.save');
		Route::post('/profile-pic-save', [SettingController::class, 'saveProfilePic'])->name('setting.updatePhotoProfile');
		Route::put('/profile-pic-delete', [SettingController::class, 'deleteProfilePic'])->name('setting.deletePhotoProfile');
	});

	Route::middleware('isAdmin')->prefix('admin')->group(function() {
		Route::get('user', [UserManagementController::class, 'index'])->name('userman.index');
		Route::get('user/{user}', [UserManagementController::class, 'show'])->name('userman.show');
		Route::put('user/{user}', [UserManagementController::class, 'destroy'])->name('userman.destroy');
		Route::post('to-admin', [UserManagementController::class, 'toAdmin'])->name('userman.toadmin');
		// admin
		Route::get('admin', [AdminManagementController::class, 'index'])->name('adminman.index');
		Route::post('admin', [AdminManagementController::class, 'store'])->name('adminman.store');
		Route::get('admin/{id}', [AdminManagementController::class, 'show'])->name('adminman.show');
		Route::put('admin/{id}', [AdminManagementController::class, 'destroy'])->name('adminman.destroy');
		Route::post('to-user', [AdminManagementController::class, 'toUser'])->name('adminman.touser');
	});
});

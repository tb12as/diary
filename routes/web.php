<?php

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
});

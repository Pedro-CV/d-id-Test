<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TalkController;
use App\Models\Talk;
use GuzzleHttp\Client;
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

Route::view('/', 'welcome')->name('home');
Route::resource('talks', TalkController::class);
Route::resource('images', ImageController::class);
Route::resource('audios', AudioController::class);

<?php

use App\Http\Controllers\BarController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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
    return view('home');
});

Auth::routes([
    "register" => false,
]);

Route::middleware(['auth', 'verified'])->group( function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/stats', [HomeController::class, 'stats'])->name('stats');

    Route::get('/theke',[BarController::class,'showClubs'])->name('clubs.show');
    Route::get('/theke/{club}/add-meter',[BarController::class,'sellMeterToClub'])->name('club.sell-meter');

    Route::get('/verein/add',[BarController::class,'showAddClub'])->name('club.show-add');
    Route::post('/verein/add',[BarController::class,'addClub'])->name('club.add');



    Route::get('/chat', [App\Http\Controllers\ChatsController::class, 'index']);
    Route::get('/messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
    Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage']);

});


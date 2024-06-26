<?php

use App\Http\Controllers\BarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatisticController;
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
    return view('home-v2');
});

Route::get('/v2', function () {
    return view('home-v2');
});

Route::get("/werbung",function (){
    return view("advertising");
});

Auth::routes([
    "register" => false,
]);

Route::middleware(['auth', 'verified'])->group( function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/stats', [HomeController::class, 'stats'])->name('stats');

    Route::get('/theke',[BarController::class,'showClubs'])->name('clubs.show');
    Route::get('/theke/{club}/add-meter',[BarController::class,'sellMeterToClub'])->name('club.sell-meter');
    Route::get('/theke/{club}/sub-meter',[BarController::class,'subMeterToClub'])->name('club.sub-meter');
    Route::get('/theke/{club}/return-meter',[BarController::class,'returnMeter'])->name('club.return-meter');

    Route::get('/theke/{soldMeterBeer}/finish',[BarController::class,'finishOrder'])->name('finishOrder');
    Route::get('/theke/{soldMeterBeer}/delete',[BarController::class,'deleteOrder'])->name('deleteOrder');

    Route::get('/verein/add',[BarController::class,'showAddClub'])->name('club.show-add');
    Route::post('/verein/add',[BarController::class,'addClub'])->name('club.add');

    Route::get('/auswertung',[StatisticController::class,'getEvaluation']);

    Route::get('/chat', [App\Http\Controllers\ChatsController::class, 'index']);
    Route::get('/messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
    Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage']);

});


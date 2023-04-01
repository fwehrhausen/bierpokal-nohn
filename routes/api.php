<?php

use App\Http\Controllers\BarController;
use App\Http\Controllers\BeerController;
use App\Http\Controllers\StatisticController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/theke/{club}/add-meter',[BarController::class,'sellMeterToClub'])->name('club.sell-meter');
Route::get('/theke/{club}/sub-meter',[BarController::class,'subMeterToClub'])->name('club.sell-meter');

Route::get('/theke/{soldMeterBeer}/finish',[BarController::class,'finishOrder'])->name('finish.order');
Route::get('/theke/{soldMeterBeer}/delete',[BarController::class,'deleteOrder'])->name('delete.order');

Route::get('/ranking',[BeerController::class,'getRanking']);
Route::get('/ranking-v2',[StatisticController::class,'getRanking']);
Route::get('/meter-beer-prognosis',[StatisticController::class,'nextMeterBeerProg']);
Route::get('/open-beer-meter',[BeerController::class,'getOpenMeters']);

Route::get('/sponsors',[BarController::class,'getSponsors']);
Route::get('/sponsors-only',[BarController::class,'getSponsorsOnly']);

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

Route::get('/ranking',[BeerController::class,'getRanking']);
Route::get('/meter-beer-prognosis',[StatisticController::class,'nextMeterBeerProg']);

Route::get('/sponsors',[BarController::class,'getSponsors']);

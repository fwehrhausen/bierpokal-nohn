<?php

namespace App\Http\Controllers;

use App\Events\MeterBeerSoldEvent;
use App\Models\Club;
use App\Models\SoldMeterBeer;
use Illuminate\Http\Request;

class BarController extends Controller
{
    public function sellMeterToClub(Club $club){

        $newSell = new SoldMeterBeer();
        $newSell->club_id = $club->id;

        $newSell->save();

        MeterBeerSoldEvent::dispatch($club);

        return redirect("/theke");
    }

    public function showClubs(){

        $clubs = Club::all();

        return view('bar.clubs')->with([
            "clubs" => $clubs
        ]);
    }
}

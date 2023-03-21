<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Database\Eloquent\Collection;

class BeerController extends Controller
{

    public function show(){


    }

    public function getRanking(): Collection|array
    {

        $clubs = Club::with(['boughtMeterBeers'])->get();

        //dd($clubs);

        $clubsRanking = $clubs->sortByDesc(function ($club){
            /** @var Club $club */
            return $club->boughtMeterBeers->count();
        });

        $chartLabels =  [];
        $chartData =  [];

        /** @var Club $clubRanking */
        foreach ($clubsRanking as $clubRanking){
            $chartLabels[] = $clubRanking->name;
            $chartData[] = $clubRanking->bought_meter_beers_count;
        }

        return [
            "labels" => $chartLabels,
            "datasets" => $chartData,
        ];
    }
}

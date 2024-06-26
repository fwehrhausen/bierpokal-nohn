<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\SoldMeterBeer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StatisticController extends Controller
{
    public function nextMeterBeerProg()
    {

        $next = new Collection();


        $soldMeterBeers = SoldMeterBeer::with(['club'])->orderBy('created_at')->get()->groupBy('club_id');

        $now = Carbon::now();
        /**
         * @var int $clubId
         * @var Collection<SoldMeterBeer> $soldMeterBeersByClub
         */
        foreach ($soldMeterBeers as $clubId => $soldMeterBeersByClub) {

            if ($soldMeterBeersByClub->count() >= 2) {
                $totalByClub = 0;
                $timeBetweenInMinTotal = 0;
                $lastBeforeCurrent = $soldMeterBeersByClub->first();
                $debugString = "";

                /**
                 * @var int $i
                 * @var SoldMeterBeer $soldMeterBeer
                 */
                foreach ($soldMeterBeersByClub as $i => $soldMeterBeer) {
                    if ($i == 0) {
                        //skip first
                        continue;
                    }
                    $totalByClub += $i;

                    $diffInMinBetweenLastAndCurrent = (Carbon::parse($lastBeforeCurrent->created_at)->diffInMinutes(Carbon::parse($soldMeterBeer->created_at)));
                    //mal $i um den späteren Metern mehr Gewichtung zugeben
                    $timeBetweenInMinTotal += $i * $diffInMinBetweenLastAndCurrent;
                    $debugString .= sprintf("(%s * %s) + ", $i, $diffInMinBetweenLastAndCurrent);

                    $lastBeforeCurrent = $soldMeterBeer;
                }

                $diff = $timeBetweenInMinTotal / $totalByClub;
                $debugString = $diff . " = " . $timeBetweenInMinTotal . " / " . $totalByClub . " [" . $debugString . "]";

                $lastBeforeTimestamp = Carbon::parse($lastBeforeCurrent->created_at);

                $nextMeterForThisClub = $lastBeforeTimestamp->addMinutes($diff)->timezone("Europe/Berlin");

                $percent = ($lastBeforeTimestamp->copy()->timestamp) / $lastBeforeTimestamp->timestamp;

                if ($nextMeterForThisClub->gt($now)) {

                    $minutesToNextUntilNow = $now->diffInMinutes($nextMeterForThisClub);

                    $next->add([
                        "club" => $lastBeforeCurrent->club->name,
                        "timestamp" => $nextMeterForThisClub->timestamp,
                        "next" => $nextMeterForThisClub->toDateTimeString(),
                        "next_string" => "in " . str_replace(" später", "", $nextMeterForThisClub->diffForHumans($now)),
                        "minutesLeft" => $minutesToNextUntilNow,
                        "percent" => $percent,
                        "debug" => $debugString,
                    ]);
                }
            }
        }

        $result = $next->sortBy(function ($entry) {
            return $entry["minutesLeft"];
        });

        return [
            "prog" => $result->values()->all(),

            ];
    }

    public function getRanking(): \Illuminate\Database\Eloquent\Collection|array
    {

        $clubs = Club::with(['boughtMeterBeers'])->get();

        //dd($clubs);

        $clubsRanking = $clubs->sortByDesc(function ($club) {
            /** @var Club $club */
            return $club->boughtMeterBeers->count();
        });


//        $chartLabels =  [];
//        $chartData =  [];
//
//        /** @var Club $clubRanking */
//        foreach ($clubsRanking as $clubRanking){
//            $chartLabels[] = $clubRanking->name;
//            $chartData[] = $clubRanking->bought_meter_beers_count;
//        }
        $isOpen = true;

        $copy = clone($clubsRanking);

        return [
            "is_open" => $isOpen,
            "top10" => $clubsRanking->splice(0,10),
            "last" => $copy->splice(10,100),
        ];
    }

    public function getEvaluation(){

        $result = new Collection();
        $totalAvrg =0;
        $clubs = Club::with(['boughtMeterBeers'])->get();

        foreach ($clubs as $club){
            $clubAvrg = 0;
            $clubDiffTotal = 0;
            $totalDiff = 0;
            $totalForArvg = 0;
            $totalForTotalArvg = 0;

            foreach ($club->boughtMeterBeers as $i => $boughtMeterBeer){

                if ($i > 0){
                    $diff = Carbon::parse($last->created_at)->diffInMinutes(Carbon::parse($boughtMeterBeer->created_at));
                    $clubDiffTotal += $diff;
                    $totalDiff += $diff;
                    $totalForArvg++;
                    $totalForTotalArvg++;
                }

                $last = $boughtMeterBeer;
            }

            if ($totalForArvg >0) {
                $clubAvrg = $clubDiffTotal / $totalForArvg;
            }

            $r =  [
                "club" => $club->name,
                "arvg" => str_replace(".",",",((string)(round($clubAvrg,3)))),
                "total" => $club->bought_meter_beers_count
            ];

            $result->add($r);
        }

        $result  =$result->sortByDesc('total')->values()->all();

        return view('evaluation')->with([
            "clubs" => $result,
            "total_arvg"  => $totalDiff/$totalForTotalArvg,
        ]);
    }
}

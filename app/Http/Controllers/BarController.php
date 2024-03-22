<?php

namespace App\Http\Controllers;

use App\Events\MeterBeerSoldEvent;
use App\Models\Club;
use App\Models\SoldMeterBeer;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class BarController extends Controller
{
    public function sellMeterToClub(Club $club){

        $newSell = new SoldMeterBeer();
        $newSell->club_id = $club->id;

        $newSell->save();

        //MeterBeerSoldEvent::dispatch($club);

        return redirect("/theke");
    }
    public function subMeterToClub(Club $club){

        $lastSell = SoldMeterBeer::where('club_id',$club->id)->orderByDesc('created_at')->first();

        if ($lastSell !== null){
            $lastSell->delete();
        }
        //MeterBeerSoldEvent::dispatch($club);

        return redirect("/theke");
    }

    public function deleteOrder(SoldMeterBeer $soldMeterBeer){
        $soldMeterBeer->delete();

        return redirect("/theke");
    }

    public function finishOrder(SoldMeterBeer $soldMeterBeer){

        $soldMeterBeer->delivered_at = Carbon::now();
        $soldMeterBeer->save();

        return redirect("/theke");
    }

    public function showClubs(){

        $clubs = Club::orderBy('name')->get();
        $openMeters = SoldMeterBeer
            ::with(["club"])
            ->whereNull('delivered_at')
            ->get();

        return view('bar.clubs')->with([
            "clubs" => $clubs,
            "openMeters" => $openMeters
        ]);
    }

    public function returnMeter(Club $club){

        /** @var null|SoldMeterBeer $lastUnreturnedMeter */
        $lastUnreturnedMeter = SoldMeterBeer::whereNotNull('delivered_at')
            ->where('club_id',$club->id)
            ->whereNull("meter_return_at")
            ->first();

        if ($lastUnreturnedMeter !== null){
            $lastUnreturnedMeter->meter_return_at = Carbon::now();
            $lastUnreturnedMeter->save();
        }

        return redirect("/theke");
    }

    public function showAddClub(){

        return view('bar.add-club');
    }

    public function addClub(Request $request){

        $newClub = new Club();
        $newClub->fill($request->input());
        $newClub->save();

        //if (Auth::user()->username === "theke"){
            return redirect("/theke");
//        }else{
//            return $this->showAddClub();
//        }
    }


    public function getSponsors(){

        $showRankingAfterXSponsors = 2;
        $sponsors = Sponsor::where('has_paid',true)->get();
        $response = new Collection();

        if ($sponsors->count() >0) {
            foreach ($sponsors as $i => $sponsor) {

                if ($i % $showRankingAfterXSponsors === 0) {
                    $ranking = new Sponsor();
                    $ranking->name = "ranking";
                    $ranking->has_paid = true;
                    $ranking->created_at = now()->toDateTimeString();
                    $ranking->updated_at = now()->toDateTimeString();
                    $response->add($ranking);
                }
                $response->add($sponsor);
            }
        }else{
            $response->add(new Sponsor([
                "name" => "ranking",
                "has_paid" => true,
            ]));
        }

        return $response;
    }
    public function getSponsorsOnly(){

        $sponsors = Sponsor::where('has_paid',true)->get();

        return $sponsors;
    }

}

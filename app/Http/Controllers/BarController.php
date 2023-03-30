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
use function Symfony\Component\Translation\t;

class BarController extends Controller
{
    public function sellMeterToClub(Club $club){

        $newSell = new SoldMeterBeer();
        $newSell->club_id = $club->id;

        $newSell->save();

        //MeterBeerSoldEvent::dispatch($club);

        return redirect("/theke");
    }

    public function showClubs(){

        $clubs = Club::orderBy('name')->get();

        return view('bar.clubs')->with([
            "clubs" => $clubs
        ]);
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

        $showRankingAfterXSponsors = 3;
        $sponsors = Sponsor::where('has_paid',true)->get();
        $response = new Collection();

        foreach ($sponsors as $i=> $sponsor){

            if ($i !== 0 && $i%$showRankingAfterXSponsors===0){
                $raninkg = new Sponsor();
                $raninkg->name = "ranking";
                $raninkg->has_paid = true;
                $raninkg->created_at = now()->toDateTimeString();
                $raninkg->updated_at = now()->toDateTimeString();
                $response->add($raninkg);
            }
            $response->add($sponsor);
        }

        return $response;
    }
}

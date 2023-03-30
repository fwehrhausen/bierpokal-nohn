<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\SoldMeterBeer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clubs = [
            "JGV Rodder",
            "JGV Hoffeld",
            "JGV Antweiler",
            "JGV Kerpen",
            "JGV Zufall",
            "JGV Saufclub 9000",
            "JGV Rodder 2",
            "JGV Eifel West",
            "JGV Leudersdorf",
            "Bitburger Braugruppe",
            "JGV Dauerstramm",
            "JGV Obelix",
            "JGV Meter für Meter",
            "JGV Kontrollverlust",
            "JGV Bier auf Wein",
            "JGV Bierschlucker",
        ];

        $createdClubs =[];

        foreach ($clubs as $clubName){

            $newClub = new Club();
            $newClub->name = $clubName;
            $newClub->save();
            $createdClubs[] = $newClub;
        }

        $totalClubs = count($createdClubs);

        for ($i =0; $i <=140; $i++){
            $soldMeter = new SoldMeterBeer();
            $soldMeter->club_id = $createdClubs[random_int(0,$totalClubs-1)]->id;
            $soldMeter->save();
        }
    }
}

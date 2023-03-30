<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imagePath = "/images/sponsoren/";

        $sponsors = [
            "Auto Kloep" => "auto_kloep.jpg",
            "Müller-Kalk" => "mueller_kalk.jpg",
            "Renault Schäfer" => "renault_schaefer.png",
            "Allfinanz Büro Hertel" => "generali_hertel.jpg",
            "Physiotherapie Raitz" => "raitz_stellenanzeige.jpg",
            "Fahrschule Hecken" =>  "fahrschule_hecken.jpeg",
            "Autoservice Kirwel" => "autoservice_kirwel.jpeg",
        ];

        foreach ($sponsors as $name => $imageName){

            $sponsor = new Sponsor();
            $sponsor->name = $name;
            $sponsor->image_url = $imagePath.$imageName;
            $sponsor->save();
        }
    }
}

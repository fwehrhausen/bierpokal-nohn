<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $bought_meter_beers_count
 * @property string last_bought_meter_beer_at
 * @property int $meters_in_circulation
 */
class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    protected $appends = [
        "bought_meter_beers_count",
        "last_bought_meter_beer_at",
        "meters_in_circulation",
    ];

    public function boughtMeterBeers(){

        return $this->hasMany(SoldMeterBeer::class)->orderByDesc('created_at');
    }

    public function getBoughtMeterBeersCountAttribute(){
        return $this->boughtMeterBeers()->count();
    }

    public function getLastBoughtMeterBeerAtAttribute(){
        $lastAt = $this->boughtMeterBeers()->first();
        if ($lastAt !== null){
            return Carbon::parse($lastAt->created_at)->format("H:i"). " Uhr";
        }else{
            return " - ";
        }
    }

    public function getMetersInCirculationAttribute(){
        return SoldMeterBeer
            ::whereNull('meter_return_at')
            ->whereNotNull('delivered_at')
            ->where('club_id',$this->id)
            ->count();
    }
}

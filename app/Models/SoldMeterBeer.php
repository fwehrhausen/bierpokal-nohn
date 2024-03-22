<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $club_id
 * @property string $delivered_at
 * @property string $meter_return_at
 */
class SoldMeterBeer extends Model
{
    use HasFactory;

    public function club(){

        return $this->belongsTo(Club::class);
    }
}

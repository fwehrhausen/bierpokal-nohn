<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sold_meter_beers', function (Blueprint $table) {
            $table->dateTime("meter_return_at")->nullable()->after("delivered_at")->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sold_meter_beers', function (Blueprint $table) {
            $table->dropColumn("meter_return_at");
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('Vietnamzone::config.tables.provinces'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string(config('Vietnamzone::config.columns.name'));
            $table->string(config('Vietnamzone::config.columns.address_code'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('Vietnamzone::config.tables.provinces'));
    }
}

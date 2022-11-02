<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('Vietnamzone::config.tables.districts'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger(config('Vietnamzone::config.columns.province_id'));
            $table->string(config('Vietnamzone::config.columns.name'));
            $table->string(config('Vietnamzone::config.columns.address_code'));
            $table->timestamps();

            $table->foreign(config('Vietnamzone::config.columns.province_id'))
                ->references('id')
                ->on(config('Vietnamzone::config.tables.provinces'))
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('Vietnamzone::config.tables.districts'));
    }
}

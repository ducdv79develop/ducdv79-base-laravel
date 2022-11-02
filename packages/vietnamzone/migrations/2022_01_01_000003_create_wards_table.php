<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('Vietnamzone::config.tables.wards'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger(config('Vietnamzone::config.columns.district_id'));
            $table->string(config('Vietnamzone::config.columns.name'));
            $table->string(config('Vietnamzone::config.columns.address_code'));
            $table->string(config('Vietnamzone::config.columns.rank'))->nullable();
            $table->string(config('Vietnamzone::config.columns.name_en'))->nullable();
            $table->timestamps();

            $table->foreign(config('Vietnamzone::config.columns.district_id'))
                ->references('id')
                ->on(config('Vietnamzone::config.tables.districts'))
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
        Schema::dropIfExists(config('Vietnamzone::config.tables.wards'));
    }
}

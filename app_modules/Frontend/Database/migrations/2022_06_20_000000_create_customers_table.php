<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('provider_user_id')->nullable();
            $table->string('provider')->nullable();
            $table->string('avatar', 256)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('email', 256)->nullable();
            $table->string('phone', 15)->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('gender')->default(0);
            $table->string('reset_token')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('password')->nullable();
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('avatar_path', 255)->nullable();
            $table->string('name', 100);
            $table->string('email', 255)->nullable()->unique();
            $table->string('phone', 15)->unique();
            $table->string('address', 255)->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('gender')->default(0);
            $table->dateTime('timeout')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('total_point')->default(0);
            $table->string('password');
            $table->rememberToken();
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
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
        Schema::dropIfExists('admins');
    }
}

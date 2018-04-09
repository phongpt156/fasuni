<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->boolean('gender');
            $table->unsignedInteger('living_city_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->rememberToken();
            $table->string('api_token', 62);
            $table->boolean('is_admin')->default(0);
            $table->integer('facebook_id')->nullable();
            $table->string('facebook_name')->nullable();
            $table->string('facebook_access_token')->nullable();
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
        Schema::dropIfExists('users');
    }
}

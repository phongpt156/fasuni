<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDeliveryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_delivery_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('receiver_address');
            $table->unsignedInteger('receiver_district_id');
            $table->unsignedInteger('receiver_ward_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('receiver_ward_id')->references('id')->on('wards')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_delivery_infos');
    }
}

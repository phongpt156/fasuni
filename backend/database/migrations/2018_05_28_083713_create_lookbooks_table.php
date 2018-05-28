<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLookbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lookbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('original_image');
            $table->string('large_image');
            $table->string('medium_image');
            $table->string('small_image');
            $table->string('thumbnail');
            $table->boolean('gender')->nullable()->comments('1: Male, 2: Female');
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
        Schema::dropIfExists('lookbooks');
    }
}

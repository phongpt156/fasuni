<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductLookbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_lookbooks', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('lookbook_id');
            $table->timestamps();

            $table->primary(['product_id', 'lookbook_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('lookbook_id')->references('id')->on('lookbooks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_lookbooks');
    }
}

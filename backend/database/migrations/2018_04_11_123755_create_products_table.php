<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('price', 10, 3);
            $table->mediumInteger('quantity')->default(0);
            $table->mediumText('about')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('gender')->nullable();
            $table->integer('click_count')->defualt(0);
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('master_product_id');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('master_product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

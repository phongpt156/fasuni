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
            $table->float('sale_price', 12, 3);
            $table->float('discount_price', 12, 3);
            $table->mediumInteger('weight')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('code')->unique();
            $table->boolean('gender')->nullable();
            $table->unsignedInteger('click_count')->default(0);
            $table->string('slug');
            $table->unsignedInteger('like_count')->default(0);
            $table->unsignedInteger('buy_count')->default(0);
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('master_product_id')->nullable();
            $table->string('kiotviet_id')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('master_product_id')->references('id')->on('products')->onDelete('set null');
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

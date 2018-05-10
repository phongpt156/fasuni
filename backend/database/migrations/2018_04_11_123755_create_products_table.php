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
            $table->float('discount_price', 10, 3)->default(0);
            $table->mediumInteger('quantity')->default(0);
            $table->mediumText('description')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('code')->unique();
            $table->boolean('gender')->nullable();
            $table->integer('click_count')->default(0);
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('master_product_id')->nullable();
            $table->unsignedInteger('branch_id')->nullable();
            $table->string('kiotviet_id')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('master_product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
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

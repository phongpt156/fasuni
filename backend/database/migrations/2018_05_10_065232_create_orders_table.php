<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->float('total_price', 12, 3);
            $table->float('discount_price', 12, 3)->default(0)->nullable();
            $table->unsignedInteger('status_id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('employee_id')->nullable();
            $table->unsignedInteger('branch_id')->nullable();
            $table->string('kiotviet_id');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('status_id')->references('id')->on('order_statuses');
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
        Schema::dropIfExists('orders');
    }
}

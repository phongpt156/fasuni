<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->float('total_price', 12, 3);
            $table->float('discount_price', 12, 3)->default(0);
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('employee_id')->nullable();
            $table->unsignedInteger('branch_id')->nullable();
            $table->unsignedInteger('order_id')->nullable();
            $table->string('kiotviet_id')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}

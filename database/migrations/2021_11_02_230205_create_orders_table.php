<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->dateTime('pay_date')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->json('snapshot')->nullable();
            $table->json('product_sku')->nullable();
            $table->json('custom_info')->nullable();
            $table->integer('status')->default(0);
            $table->string('pay_method')->nullable();
            $table->json('pay_info')->nullable();
            $table->string('price')->nullable();
            $table->string('order_id')->index()->nullable();
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
        Schema::dropIfExists('orders');
    }
}

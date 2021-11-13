<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('title')->nullable();
            $table->decimal('price')->nullable();
            $table->boolean('show')->default(1);
            $table->integer('sales')->nullable();

            $table->unsignedBigInteger('attribute_id')->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->json('attributes')->nullable();
            $table->json('skus')->nullable();
            $table->timestamps();
        });

        Schema::create('product_has_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');
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
        Schema::dropIfExists('product_has_categories');
    }
}

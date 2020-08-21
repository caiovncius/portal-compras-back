<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('discountDeferred');
            $table->integer('discountOnCash');
            $table->integer('minimum');
            $table->integer('minimumPerFamily');
            $table->boolean('obrigatory')->default(0);
            $table->boolean('variable')->default(0);
            $table->boolean('family')->default(0);
            $table->boolean('gift')->default(0);
            $table->decimal('factoryPrice', 10, 2);
            $table->decimal('priceDeferred', 10, 2);
            $table->decimal('priceOnCash', 10, 2);
            $table->string('productName');
            $table->integer('quantityMaximum');
            $table->integer('quantityMinimum');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->timestamps();

            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_products');
    }
}

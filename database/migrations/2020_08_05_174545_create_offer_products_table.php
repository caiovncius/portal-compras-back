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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('discount_deferred');
            $table->integer('discount_on_cash');
            $table->integer('minimum');
            $table->integer('minimum_per_family');
            $table->boolean('obrigatory')->default(0);
            $table->boolean('variable')->default(0);
            $table->boolean('family')->default(0);
            $table->boolean('gift')->default(0);
            $table->decimal('factory_price', 10, 2);
            $table->decimal('price_deferred', 10, 2);
            $table->decimal('price_on_cash', 10, 2);
            $table->string('product_name');
            $table->integer('quantity_maximum');
            $table->integer('quantity_minimum');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->bigInteger('productable_id')->nullable();
            $table->string('productable_type')->nullable();
            $table->timestamps();

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

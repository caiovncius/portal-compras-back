<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offerProduct_request', function (Blueprint $table) {
            $table->unsignedBigInteger('offer_product_id');
            $table->unsignedBigInteger('request_id');
            $table->integer('qtd');

            $table->foreign('offer_product_id')->references('id')->on('offer_products');
            $table->foreign('request_id')->references('id')->on('requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_request');
    }
}

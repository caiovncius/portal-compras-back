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
        Schema::create('request_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('return_id')->nullable();
            $table->integer('qtd');
            $table->integer('qtd_return')->nullable();
            $table->enum('status', ['CREATED', 'ATTENDED', 'ATTENDED_PARTIAL', 'NOT_ATTENDED']);
            $table->decimal('value', 10, 2);
            $table->bigInteger('partner_id')->nullable();
            $table->string('partner_type')->nullable();

            $table->foreign('return_id')->references('id')->on('returns');
            $table->foreign('product_id')->references('id')->on('products');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewRequestProductsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('product_id');
            $table->enum('status', ['ATTENDED', 'PARTIALLY_ATTENDED', 'NOT_ATTENDED'])->nullable();
            $table->bigInteger('return_id')->nullable();
            $table->integer('requested_quantity');
            $table->integer('quantity_served')->nullable();
            $table->decimal('unit_value');
            $table->integer('discount_percentage')->nullable();
            $table->decimal('subtotal');
            $table->decimal('total_discount');
            $table->decimal('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_products');
    }
}

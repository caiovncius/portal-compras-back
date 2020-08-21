<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOfferProductRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('offerProduct_request', 'request_products');

        Schema::table('request_products', function (Blueprint $table) {
            $table->integer('qtdReturn')->nullable();
            $table->integer('status')->nullable();
            $table->unsignedBigInteger('distributor_id')->nullable();

            $table->foreign('distributor_id')->references('id')->on('distributors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

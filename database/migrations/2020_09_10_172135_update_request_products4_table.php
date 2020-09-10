<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestProducts4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_products', function (Blueprint $table) {
            $table->dropForeign('offerProduct_request_offer_product_id_foreign');
            $table->dropColumn('product_detail_id');
        });

        Schema::table('request_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
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
        Schema::table('request_products', function (Blueprint $table) {
            $table->dropForeign('request_products_product_id_foreign');
            $table->dropColumn('product_id');
            $table->unsignedBigInteger('product_detail_id');
        });
    }
}

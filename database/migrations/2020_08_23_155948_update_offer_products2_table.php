<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOfferProducts2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('offer_products', 'product_details');
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropForeign('offer_products_offer_id_foreign');
            $table->dropColumn('offer_id');
            $table->dropColumn('productName');

            $table->integer('productable_id')->nullable();
            $table->string('productable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('product_details', 'offer_products');
        Schema::table('offer_products', function (Blueprint $table) {
            $table->unsignedBigInteger('offer_id');

            $table->dropColumn('productable_id');
            $table->dropColumn('productable_type');

            $table->foreign('offer_id')->references('id')->on('offers');
        });
    }
}

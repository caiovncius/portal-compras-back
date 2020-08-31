<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->renameColumn('discountDeferred', 'discount_deferred');
            $table->renameColumn('discountOnCash', 'discount_on_cash');
            $table->renameColumn('minimumPerFamily', 'minimum_per_family');
            $table->renameColumn('factoryPrice', 'factory_price');
            $table->renameColumn('priceDeferred', 'price_deferred');
            $table->renameColumn('priceOnCash', 'price_on_cash');
            $table->renameColumn('quantityMaximum', 'quantity_maximum');
            $table->renameColumn('quantityMinimum', 'quantity_minimum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->renameColumn('discount_deferred', 'discountDeferred');
            $table->renameColumn('discount_on_cash', 'discountOnCash');
            $table->renameColumn('minimum_per_family', 'minimumPerFamily');
            $table->renameColumn('factory_price', 'factoryPrice');
            $table->renameColumn('price_deferred', 'priceDeferred');
            $table->renameColumn('price_on_cash', 'priceOnCash');
            $table->renameColumn('quantity_maximum', 'quantityMaximum');
            $table->renameColumn('quantity_minimum', 'quantityMinimum');
        });
    }
}

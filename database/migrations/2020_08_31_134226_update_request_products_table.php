<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_products', function (Blueprint $table) {
            $table->renameColumn('offer_product_id', 'product_detail_id');
            $table->renameColumn('qtdReturn', 'qtd_return');
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
            $table->renameColumn('product_detail_id', 'offer_product_id');
            $table->renameColumn('qtd_return', 'qtdReturn');
        });
    }
}

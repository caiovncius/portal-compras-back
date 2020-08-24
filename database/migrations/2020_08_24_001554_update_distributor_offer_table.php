<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDistributorOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributor_offer', function (Blueprint $table) {
            $table->integer('ol')->nullable();
            $table->integer('priority')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distributor_offer', function (Blueprint $table) {
            $table->dropColumn('ol');
            $table->dropColumn('priority');
        });
    }
}

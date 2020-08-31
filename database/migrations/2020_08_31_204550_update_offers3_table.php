<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOffers3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->renameColumn('startDate', 'start_date');
            $table->renameColumn('endDate', 'end_date');
            $table->renameColumn('minimumPrice', 'minimum_price');
            $table->renameColumn('offerType', 'offer_type');
            $table->renameColumn('sendType', 'send_type');
            $table->renameColumn('noAutomaticSending', 'no_automatic_sending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->renameColumn('start_date', 'startDate');
            $table->renameColumn('end_date', 'endDate');
            $table->renameColumn('minimum_price', 'minimumPrice');
            $table->renameColumn('offer_type', 'offerType');
            $table->renameColumn('send_type', 'sendType');
            $table->renameColumn('no_automatic_sending', 'noAutomaticSending');
        });    }
}

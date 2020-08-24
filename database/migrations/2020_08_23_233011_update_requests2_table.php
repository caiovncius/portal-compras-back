<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequests2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign('requests_offer_id_foreign');
            $table->dropColumn('offer_id');

            $table->integer('partner_id')->nullable();
            $table->integer('priority')->nullable();
            $table->integer('requestable_id')->nullable();
            $table->string('requestable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->unsignedBigInteger('offer_id');

            $table->dropColumn('partner_id');
            $table->dropColumn('priority');
            $table->dropColumn('requestable_id');
            $table->dropColumn('requestable_type');

            $table->foreign('offer_id')->references('id')->on('offers');
        });
    }
}

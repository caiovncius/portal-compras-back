<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDistributorConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributor_connections', function (Blueprint $table) {
            $table->dropForeign(['distributor_id']);
            $table->dropColumn('distributor_id');

            $table->integer('connectionable_id')->nullable();
            $table->string('connectionable_type')->nullable();
        });

        Schema::rename('distributor_connections', 'connections');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('connections', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_id');
            
            $table->foreign('distributor_id')->references('id')->on('distributors');

            $table->dropColumn('connectionable_id');
            $table->dropColumn('connectionable_type');
        });

        Schema::rename('connections', 'distributor_connections');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestProducts2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('request_products', function (Blueprint $table) {
            $table->enum('status', ['CREATED', 'ATTENDED', 'ATTENDED_PARTIAL', 'NOT_ATTENDED']);
            $table->unsignedBigInteger('return_id')->nullable();
            $table->decimal('value', 10, 2);

            $table->foreign('return_id')->references('id')->on('returns');
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
            $table->string('status')->change();
            $table->dropColumn('value');
            $table->dropForeign('request_products_return_id_foreign');
            $table->dropColumn('return_id');
        });
    }
}

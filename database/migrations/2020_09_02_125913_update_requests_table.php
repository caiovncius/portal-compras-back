<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('requests', function (Blueprint $table) {
            $table->enum('status', ['NOT_SEND', 'CREATED', 'WAITING_RETURN', 'ERROR_ON_SEND', 'BILLED', 'BILLED_PARTIAL', 'NOT_BILLED']);
            $table->decimal('value', 10, 2);
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
            $table->string('status')->change();
            $table->dropColumn('value');
        });
    }
}

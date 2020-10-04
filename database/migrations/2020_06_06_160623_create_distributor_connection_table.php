<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorConnectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->boolean('ftp_active');
            $table->string('transferency');
            $table->string('host');
            $table->string('path_send');
            $table->string('login');
            $table->string('password');
            $table->string('path_return');
            $table->string('mask')->nullable();
            $table->boolean('remove_file')->nullable();
            $table->string('port')->nullable();
            $table->bigInteger('updated_id')->nullable();
            $table->bigInteger('connectionable_id')->nullable();
            $table->string('connectionable_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributor_connection');
    }
}

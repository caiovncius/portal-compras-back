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
        Schema::create('distributor_connections', function (Blueprint $table) {
            $table->id();
            $table->boolean('ftp_active');
            $table->string('transferency');
            $table->string('host');
            $table->string('path_send');
            $table->string('login');
            $table->string('password');
            $table->string('path_return');
            $table->unsignedBigInteger('distributor_id');
            $table->timestamps();

            $table->foreign('distributor_id')->references('id')->on('distributors');
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

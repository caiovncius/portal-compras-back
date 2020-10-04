<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->longText('image')->nullable();
            $table->string('code');
            $table->string('name');
            $table->string('status');
            $table->string('description');
            $table->datetime('start_fate')->nullable();
            $table->datetime('end_date')->nullable();
            $table->bigInteger('condition_id')->nullable();
            $table->string('minimum_price')->nullable();
            $table->enum('offer_type', ['NORMAL', 'COMBO', 'COLLECTIVE_BUYING'])->nullable();
            $table->enum('send_type', ['MANUAL', 'AUTOMATIC'])->nullable();
            $table->boolean('no_automatic_sending')->default(1)->nullable();
            $table->boolean('impound')->default(0)->nullable();
            $table->json('emails')->nullable();
            $table->bigInteger('updated_id')->nullable();
            $table->timestamps();

            $table->foreign('condition_id')->references('id')->on('conditions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}

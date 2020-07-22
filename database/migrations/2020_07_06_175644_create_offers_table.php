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
            $table->datetime('startDate')->nullable();
            $table->datetime('endDate')->nullable();
            $table->string('condition')->nullable();
            $table->string('minimumPrice')->nullable();
            $table->string('offerType')->nullable();
            $table->enum('sendType', ['MANUAL', 'AUTOMATIC'])->nullable();
            $table->boolean('noAutomaticSending')->default(1)->nullable();
            $table->boolean('impound')->default(0)->nullable();
            $table->json('emails')->nullable();
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
        Schema::dropIfExists('offers');
    }
}

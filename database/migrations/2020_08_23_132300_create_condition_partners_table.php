<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConditionPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condition_partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condition_id');
            $table->unsignedBigInteger('partnerId');
            $table->string('partnerType');
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
        Schema::dropIfExists('condition_partners');
    }
}

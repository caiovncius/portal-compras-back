<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class   CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('distributor_offer');
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('typable_id');
            $table->string('typable_type');
            $table->unsignedBigInteger('partner_id');
            $table->string('partner_type');
            $table->integer('ol')->nullable();
            $table->integer('priority')->nullable();
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
        Schema::dropIfExists('partners');
    }
}

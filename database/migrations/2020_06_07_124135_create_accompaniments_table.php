<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccompanimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accompaniments', function (Blueprint $table) {
            $table->id();
            $table->integer('code_order');
            $table->integer('code_pharmacy');
            $table->string('cnpj');
            $table->date('date_create');
            $table->date('date_publish');
            $table->string('commercial');
            $table->string('type_send');
            $table->string('status');
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
        Schema::dropIfExists('accompaniments');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileFunctionalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_functionalities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('functionality_id');
            $table->enum('access_type', ['FREE_ACCESS', 'READ_ACCESS', 'NO_ACCESS'])
                ->default('FREE_ACCESS');
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('profiles');
            $table->foreign('functionality_id')->references('id')->on('functionalities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_functionalities');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdatedId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accompaniments', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('conditions', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('connections', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('distributors', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('functionalities', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('laboratories', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('pharmacies', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('publicities', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('returns', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

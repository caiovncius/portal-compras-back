<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('company_name');
            $table->string('name');
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->string('cnpj')->unique();
            $table->string('state_registration')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->bigInteger('supervisor_id')->nullable();
            $table->string('partner_priority')->nullable();
            $table->string('address')->nullable();
            $table->string('address_2')->nullable();
            $table->string('address_number')->nullable();
            $table->string('district')->nullable();
            $table->string('zip_code')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->bigInteger('updated_id')->nullable();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacies');
    }
}

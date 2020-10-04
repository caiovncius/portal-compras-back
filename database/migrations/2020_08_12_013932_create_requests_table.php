<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pharmacy_id');
            $table->string('status')->nullable();
            $table->integer('partner_id')->nullable();
            $table->string('partner_type')->nullable();
            $table->integer('priority')->nullable();
            $table->integer('requestable_id')->nullable();
            $table->string('requestable_type')->nullable();
            $table->enum('status', ['NOT_SEND', 'CREATED', 'WAITING_RETURN', 'ERROR_ON_SEND', 'BILLED', 'BILLED_PARTIAL', 'NOT_BILLED']);
            $table->decimal('value', 10, 2);
            $table->date('send_date')->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->enum('payment_method', ['CASH', 'TERM'])->after('id')->default('CASH');
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->timestamps();

            $table->foreign('pharmacy_id')->references('id')->on('pharmacies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}

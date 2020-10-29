<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewRequestTables extends Migration
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
            $table->string('partner_type');
            $table->bigInteger('partner_id');
            $table->string('requestable_type');
            $table->bigInteger('requestable_id');
            $table->integer('priority')->default(1);
            $table->enum('status', ['NOT_SEND','CREATED','WAITING_RETURN','ERROR_ON_SEND','BILLED','BILLED_PARTIAL','NOT_BILLED','CANCELED'])
                ->default('CREATED');
            $table->enum('payment_method', ['CASH', 'TERM'])->default('TERM');
            $table->decimal('subtotal');
            $table->decimal('total_discount');
            $table->decimal('total');
            $table->dateTime('send_date')->nullable();
            $table->bigInteger('updated_id')->nullable();
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
        Schema::dropIfExists('requests');
    }
}

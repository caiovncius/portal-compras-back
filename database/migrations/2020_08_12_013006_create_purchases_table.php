<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->longText('image')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('send_type')->nullable();
            $table->enum('status', ['OPEN', 'LATE', 'READY_SEND', 'BILLED'])
                ->default('OPEN');
            $table->date('validity_start')->nullable();
            $table->date('validity_end')->nullable();
            $table->boolean('until_billing')->default(0);
            $table->enum('billing_measure', ['VALUE', 'QUANTITY'])->default('VALUE');
            $table->integer('set_minimum_billing_value')->nullable();
            $table->integer('minimum_billing_value')->nullable();
            $table->integer('set_minimum_billing_quantity')->nullable();
            $table->integer('minimum_billing_quantity')->nullable();
            $table->integer('total_intentions_value')->nullable();
            $table->integer('total_intentions_quantity')->nullable();
            $table->integer('related_quantity')->nullable();
            $table->mediumText('description')->nullable();
            $table->datetime('billed_date')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->json('contacts')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}

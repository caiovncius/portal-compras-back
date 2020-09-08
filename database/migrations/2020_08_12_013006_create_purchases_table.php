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
            $table->unsignedBigInteger('offer_id');
            $table->longText('image')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('sendType')->nullable();
            $table->enum('status', ['OPEN', 'LATE', 'READY_SEND', 'BILLED'])
                ->default('OPEN');
            $table->date('validityStart')->nullable();
            $table->date('validityEnd')->nullable();
            $table->boolean('untilBilling')->default(0);
            $table->integer('setMinimumBillingValue')->nullable();
            $table->integer('minimumBillingValue')->nullable();
            $table->integer('setMinimumBillingQuantity')->nullable();
            $table->integer('minimumBillingQuantity')->nullable();
            $table->integer('totalIntentionsValue')->nullable();
            $table->integer('totalIntentionsQuantity')->nullable();
            $table->integer('relatedQuantity')->nullable();
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
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

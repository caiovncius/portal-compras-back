<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->renameColumn('sendType', 'send_type');
            $table->renameColumn('validityStart', 'validity_start');
            $table->renameColumn('validityEnd', 'validity_end');
            $table->renameColumn('untilBilling', 'until_billing');
            $table->renameColumn('setMinimumBillingValue', 'set_minimum_billing_value');
            $table->renameColumn('minimumBillingValue', 'minimum_billing_value');
            $table->renameColumn('setMinimumBillingQuantity', 'set_minimum_billing_quantity');
            $table->renameColumn('minimumBillingQuantity', 'minimum_billing_quantity');
            $table->renameColumn('totalIntentionsValue', 'total_intentions_value');
            $table->renameColumn('totalIntentionsQuantity', 'total_intentions_quantity');
            $table->renameColumn('relatedQuantity', 'related_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

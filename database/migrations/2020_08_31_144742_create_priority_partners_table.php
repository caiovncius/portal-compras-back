<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriorityPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priority_partners', function (Blueprint $table) {
            $table->unsignedBigInteger('priority_id');
            $table->unsignedBigInteger('distributor_id');
            $table->boolean('quick_access')->default(false);

            $table->foreign('priority_id')->references('id')->on('priorities');
            $table->foreign('distributor_id')->references('id')->on('distributors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('priority_partners');
    }
}

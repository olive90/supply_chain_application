<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PurchaseRequestMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puchase_request_master', function (Blueprint $table) {
            $table->id();
            $table->string('pr_id');
            $table->integer('category');
            $table->text('special_ordering_instructions');
            $table->text('shipping_instructions');
            $table->integer('request_by');
            $table->integer('status');
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
        Schema::dropIfExists('puchase_request_master');
    }
}

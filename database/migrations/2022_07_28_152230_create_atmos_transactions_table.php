<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtmosTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atmos_transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('payable');
            $table->text('transaction_id');
            $table->text('success_trans_id')->nullable();
            $table->text('terminal_id')->nullable();
            $table->text('prepay_time')->nullable();
            $table->text('confirm_time')->nullable();
            $table->text('card_id')->nullable();
            $table->text('status_code')->nullable();
            $table->text('status_message')->nullable();
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
        Schema::dropIfExists('atmos_transactions');
    }
}

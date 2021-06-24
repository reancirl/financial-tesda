<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiddingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidding_items', function (Blueprint $table) {
            $table->id();
            $table->integer('bidding_id');
            $table->integer('purchase_request_item_id');
            $table->decimal('price_one',8,2)->nullable();
            $table->decimal('price_two',8,2)->nullable();
            $table->decimal('price_three',8,2)->nullable();
            $table->integer('winner_supplier_id')->nullable();
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
        Schema::dropIfExists('bidding_items');
    }
}

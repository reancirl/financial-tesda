<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('qualification_id');
            $table->integer('purchase_request_id');
            $table->string('supplier');
            $table->string('mode_of_procurement')->nullable();
            $table->integer('delivery_term')->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('is_submitted')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}

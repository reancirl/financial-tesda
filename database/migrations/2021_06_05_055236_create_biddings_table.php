<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiddingsTable extends Migration
{
    public function up()
    {
        Schema::create('biddings', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_request_id');
            $table->integer('user_id');
            $table->integer('is_done')->default(0);
            $table->integer('is_approved')->default(0);
            $table->integer('supplier_one_id')->nullable();
            $table->integer('supplier_two_id')->nullable();
            $table->integer('supplier_three_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('biddings');
    }
}

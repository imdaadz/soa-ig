<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('merchant_id');
            $table->bigInteger('product_id');
            $table->string('product_name');
            $table->string('shopee_link');
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
        Schema::dropIfExists('shopee');
    }
}

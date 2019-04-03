<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstagramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instagrams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('media_ig_id');
            $table->string('shortcode');
            $table->string('link');
            $table->string('caption');
            $table->string('ig_image');
            $table->string('product');
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
        Schema::dropIfExists('instagrams');
    }
}

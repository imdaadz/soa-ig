<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInstagramUserColumnToInstagram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instagrams', function (Blueprint $table) {
             $table->string('instagram_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instagrams', function (Blueprint $table) {
             $table->dropColumn('instagram_user');
        });
    }
}

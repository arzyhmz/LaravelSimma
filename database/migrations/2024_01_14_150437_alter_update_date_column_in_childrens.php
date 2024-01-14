<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUpdateDateColumnInChildrens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('childrens', function (Blueprint $table) {
            $table->string('udpate_date')->nullable()->change();
        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('childrens', function (Blueprint $table) {
            //
        });
    }
}

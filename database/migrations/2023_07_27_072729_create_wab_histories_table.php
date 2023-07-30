<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWabHistoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wab_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('partner_id')->nullable();
            $table->string('room_id')->nullable();
            $table->text('chat')->nullable();
            $table->string('status')->nullable();
            $table->date('update_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wab_histories');
    }
}

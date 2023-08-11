<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrensTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('childrens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('partner_id')->nullable();
            $table->string('pledge_id')->nullable();
            $table->string('paid_thru')->nullable();
            $table->string('name')->nullable();
            $table->string('idn')->nullable();
            $table->string('status')->nullable();
            $table->string('message')->nullable();
            $table->date('udpate_date')->nullable();
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
        Schema::drop('childrens');
    }
}

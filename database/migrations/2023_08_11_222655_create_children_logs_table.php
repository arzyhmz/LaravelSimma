<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrenLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->nullable();
            $table->string('date')->nullable();
            $table->integer('total')->nullable();
            $table->string('list_id')->nullable();
            $table->string('failed_list_id')->nullable();
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
        Schema::drop('children_logs');
    }
}

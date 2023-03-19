<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('status')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('source')->nullable();
            $table->string('sponsor_id')->nullable();
            $table->string('name_see')->nullable();
            $table->string('motivation_code')->nullable();
            $table->date('join_date')->nullable();
            $table->string('sp')->nullable();
            $table->string('title')->nullable();
            $table->string('en')->nullable();
            $table->string('pl')->nullable();
            $table->string('dr')->nullable();
            $table->string('email_sponsor')->nullable();
            $table->string('need_tp_post')->nullable();
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
        Schema::drop('contacts');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('posted_to_qontact_date')->nullable();
            $table->string('error_message')->nullable();
            $table->string('posted_status')->nullable(); #success, failed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('contacts', function (Blueprint $table) {
        //     $table->string('posted_to_qontact_date')->nullable();
        //     $table->string('error_message')->nullable();
        //     $table->string('posted_status')->nullable(); #success, failed
        // });
    }
}

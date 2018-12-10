<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('address', 255)->nullable();
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
        Schema::dropIfExists('customers');
    }
}

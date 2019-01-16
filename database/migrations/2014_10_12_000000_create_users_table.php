<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_number')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('gender')->default(1);
            $table->date('date_of_birth')->nullable();
            $table->string('bio', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->date('start_work_date')->nullable();
            $table->date('pay_day')->nullable();
            $table->decimal('base_salary', 20, 2)->nullable();
            $table->string('avatar_url')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('full_time')->default(1);
            $table->integer('rate')->default(1);
            $table->dateTime('resigned_at')->nullable();
            $table->string('locale')->default('en');
            $table->decimal('bonus', 20, 2)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

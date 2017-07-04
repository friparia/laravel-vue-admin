<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
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
            $table->timestamps();
            $table->string('username');
            $table->string('remember_token')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default();

        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->index();
            $table->integer('role_id')->index();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('role_user');

    }
}

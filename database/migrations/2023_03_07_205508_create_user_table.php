<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('password')->nullable();
            $table->unsignedBigInteger('profile_id')->default(2)->nullable();
            $table->foreign('profile_id')->references('id')->on('profile');
            $table->boolean('active')->default(false);
            $table->integer('unauthorized')->default(0);
            $table->string('fcm_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
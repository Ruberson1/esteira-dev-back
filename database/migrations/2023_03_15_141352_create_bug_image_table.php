<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bug_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bug_id');
            $table->string('path');
            $table->timestamp('register_date')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('bug_id')->references('id')->on('bug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bug_image');
    }
}

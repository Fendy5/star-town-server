<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('用户Id，外键');
            $table->unsignedBigInteger('work_id')->comment('作品Id，外键');
            $table->foreign('user_id')->references('id')->on('st_users');
            $table->foreign('work_id')->references('id')->on('st_works');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('st_likes');
    }
}

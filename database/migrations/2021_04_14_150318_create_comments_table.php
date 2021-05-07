<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('用户Id，外键');
            $table->unsignedBigInteger('work_id')->comment('作品Id，外键');
            $table->unsignedBigInteger('comment_id')->comment('评论Id，外键')->nullable();
            $table->unsignedBigInteger('to_id')->comment('外键')->nullable();
            $table->foreign('user_id')->references('id')->on('st_users');
            $table->foreign('work_id')->references('id')->on('st_works');
            $table->foreign('comment_id')->references('id')->on('st_comments');
            $table->foreign('to_id')->references('id')->on('st_users');
            $table->string('content')->comment('评论内容');
            $table->softDeletes();
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
        Schema::dropIfExists('st_comments');
    }
}

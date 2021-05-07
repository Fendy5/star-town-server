<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('用户ID，外键');
            $table->string('title', 128)->comment('标题');
            $table->string('desc', 256)->comment('简介');
            $table->char('type',1)->comment('作品类型(1-文字，2-小说，3-时评，4-漫画，5-写真，6-手绘)');
            $table->string('cover', 128)->default('https://image.fendy5.cn/s/TFCSJrpH0teKhjR.png')->comment('封面');
            $table->text('content')->comment('作品内容');
            $table->foreign('user_id')->references('id')->on('st_users');
            $table->softDeletes()->comment('');
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
        Schema::dropIfExists('st_works');
    }
}

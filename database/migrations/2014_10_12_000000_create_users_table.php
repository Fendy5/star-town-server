<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cc_id')->comment('用户Id，外键')->nullable();
            $table->foreign('cc_id')->references('id')->on('st_circles');
            $table->string('nickname')->comment('昵称');
//            $table->string('email')->unique();
            $table->string('phone')->unique()->comment('手机号码，唯一约束');
            $table->string('password')->comment('密码，bcrypt算法加密');
            $table->string('avatar')->default('https://image.fendy5.cn/s/LNSrEIFMnPR7kwVt.jpg')->comment('头像');
            $table->softDeletes()->comment('软删除标识');
//            $table->foreign('cp_id')->references('id')->on('st_cps');
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
        Schema::dropIfExists('st_users');
    }
}

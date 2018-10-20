<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name')->default('')->comment('上传文件名')->unique();
            $table->string('user_id')->default('')->comment('用户id');
            $table->string('movie_src')->default('')->comment('本地电影地址');
            $table->tinyInteger('status')->default(0)->comment('0:初始状态；-1：上传失败；1：上传中；2：上传成功');
            $table->string('pages')->default('')->comment('总片数');
            $table->string('current_page')->default('')->comment('当前片数');
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
        Schema::dropIfExists('uploads');
    }
}

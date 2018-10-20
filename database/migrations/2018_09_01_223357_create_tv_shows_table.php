<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tv_shows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('电视剧名')->index();
            $table->string('tv_code')->default('')->comment('电视剧编号')->index();
            $table->string('code')->default('')->comment('电视剧具体编号')->index();
            $table->string('en_name')->default('')->comment('电视剧英文名');
            $table->string('upload_user')->default('admin')->comment('上传用户')->index();
            $table->string('director')->default('')->comment('导演');
            $table->string('main_performer')->default('')->comment('主演');
            $table->tinyInteger('type')->default(-1)->comment('电视剧类型');
            $table->tinyInteger('menu_type')->default(-1)->comment('2:电视剧,3:综艺娱乐');
            $table->string('seasons')->default('')->comment('第几季');
            $table->Integer('episodes')->comment('第几集');
            $table->Integer('views')->default(0)->comment('观看次数');
            $table->Integer('score')->default(0)->comment('总得分');
            $table->Integer('comment_tmies')->default(0)->comment('评影次数');
            $table->tinyInteger('areas')->default(-1)->comment('欧美1,内地0');
            $table->string('comment')->default('')->comment('电视剧介绍');
            $table->string('show_date')->default('')->comment('上映时间');
            $table->string('time')->default('')->comment('视频时长');
            $table->string('img_url')->default('')->comment('图片地址');
            $table->string('movies_url')->default('')->comment('电影地址json');
            $table->Integer('status')->default(0)->comment('0:未审核,1:已审核,-1:失效');
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
        Schema::dropIfExists('tv_shows');
    }
}

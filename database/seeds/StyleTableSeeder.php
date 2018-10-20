<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StyleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('style')->insert([[
            'name' => '爱情',
            'code' => '0',
        ],[
            'name' => '动作',
            'code' => '1',
        ],[
            'name' => '喜剧',
            'code' => '2',
        ],[
            'name' => '惊悚',
            'code' => '3',
        ],[
            'name' => '恐怖',
            'code' => '4',
        ],[
            'name' => '悬疑',
            'code' => '5',
        ],[
            'name' => '奇幻',
            'code' => '6',
        ],[
            'name' => '历史',
            'code' => '7',
        ],[
            'name' => '灾难',
            'code' => '8',
        ],[
            'name' => '冒险',
            'code' => '9',
        ],[
            'name' => '励志',
            'code' => '10',
        ],[
            'name' => '青春',
            'code' => '11',
        ],[
            'name' => '儿童',
            'code' => '12',
        ],[
            'name' => '家庭',
            'code' => '13',
        ],[
            'name' => '伦理',
            'code' => '14',
        ],[
            'name' => '动画',
            'code' => '15',
        ],]);
    }
}

<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu')->insert([[
            'en_name' => 'movies',
            'name' => '电影',
            'a_class' => 'movies-icon',
            's_class' => 'glyphicon glyphicon-film',
        ],[
            'en_name' => 'shows',
            'name' => '电视剧',
            'a_class' => 'movies-icon',
            's_class' => 'glyphicon glyphicon-home glyphicon-blackboard',
        ],[
            'en_name' => 'entertainments',
            'name' => '综艺娱乐',
            'a_class' => 'entertainments-icon',
            's_class' => 'glyphicon glyphicon-home glyphicon-king',
        ]]);
    }
}

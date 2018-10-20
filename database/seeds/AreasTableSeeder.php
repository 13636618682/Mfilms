<?php

use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([[
            'name' => '大陆',
            'en_name' => 'Mainland China',
            'code' => 0,
        ],[
            'name' => '欧美',
            'en_name' => 'Europe and America',
            'code' => 1,
        ],[
            'name' => '港台',
            'en_name' => 'Hong Kong and Taiwan',
            'code' => 2,
        ],[
            'name' => '日韩',
            'en_name' => 'Japan and South Korea',
            'code' => 3,
        ],[
            'name' => '其他',
            'en_name' => 'Others',
            'code' => 4,
        ],]);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    protected $table = 'movies';
    protected $primaryKey = 'id';
    protected $fillable = ['name'
        ,'en_name'
        ,'code'
        ,'upload_user'
        ,'director'
        ,'type'
        ,'menu_type'
        ,'views'
        ,'score'
        ,'comment_tmies'
        ,'areas'
        ,'comment'
        ,'show_date'
        ,'img_url'
        ,'movies_url'
        ,'status'        ];
}

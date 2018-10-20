<?php

namespace App\Http\Controllers\Films;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Menu;
use App\Areas;

class SearchController extends Controller
{
    protected function index(Request $request)
    {
        $menu = Menu::all();
        $areas = Areas::all();
        $search = $request->get('search');
        $like = " name like '%$search%' or en_name like '%$search%' or director like '%$search%' or comment like '%$search%' ";
        $sql = "(SELECT `name`,`en_name`,`code`,`upload_user`,`director`,
                   `type`,`menu_type`,`views`,`score`,`comment_tmies`,`areas`,`img_url`,`time`,null as seasons,
                    `movies_url`,`status`,`created_at` FROM movies WHERE $like)
                UNION (SELECT `name`,`en_name`,`code`,`upload_user`,`director`,`type`,`menu_type`,`views`,`score`
                    ,`comment_tmies`,`areas`,`img_url`,`time`,`seasons`,`movies_url`,`status`,`created_at`
                    FROM tv_shows WHERE $like GROUP BY tv_code) ORDER BY created_at DESC";

        $data = DB::select($sql);

        return view('films.search',compact('menu','areas','data'));
    }
}

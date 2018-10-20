<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Menu;
use App\Areas;
use Illuminate\Support\Facades\DB;


class UserInfoController extends Controller
{
    protected function index(Request $request){
        $id = $request->route('id');
        $menu = Menu::all();
        $areas = Areas::all();
        $data = User::where('id',$id)->get();
        $conditions =  " WHERE status != -1 AND upload_user = '{$data[0]->name}' ";
        if($data[0]->name=='admin'){
            $conditions = '';
        }
        $sql = "(SELECT `name`,`en_name`,`code`,`upload_user`,`director`,
                   `type`,`menu_type`,`views`,`score`,`comment_tmies`,`areas`,`img_url`,`time`,null as seasons,
                    `movies_url`,`status`,`created_at` FROM movies $conditions )
                UNION (SELECT `name`,`en_name`,`code`,`upload_user`,`director`,`type`,`menu_type`,`views`,`score`
                    ,`comment_tmies`,`areas`,`img_url`,`time`,`seasons`,`movies_url`,`status`,`created_at`
                    FROM tv_shows $conditions ) ORDER BY created_at DESC LIMIT 0,10";

        $dataF = DB::select($sql);
        return view('auth.index',compact('dataF','data','menu','areas'));
    }
}

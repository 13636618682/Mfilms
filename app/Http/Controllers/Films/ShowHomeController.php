<?php

namespace App\Http\Controllers\Films;

use App\TvShows;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;
use App\Areas;
use App\Movies;
use Illuminate\Support\Facades\DB;

class ShowHomeController extends Controller
{
    protected function index(){
        $menu = Menu::all();
        $areas = Areas::all();

        $recentFilmAll = DB::select("(SELECT `name`,`en_name`,`code`,`upload_user`,`director`,`type`,`menu_type`,`views`,`score`
                    ,`comment_tmies`,`areas`,`img_url`,`time`,`seasons`,`movies_url`,`status`,`created_at`
                    FROM (SELECT * FROM tv_shows ORDER BY tv_code,created_at DESC) AS tv
                   WHERE status != -1 GROUP BY tv_code,seasons) UNION (SELECT `name`,`en_name`,`code`,`upload_user`,`director`,
                   `type`,`menu_type`,`views`,`score`,`comment_tmies`,`areas`,`img_url`,`time`,null as seasons,
                    `movies_url`,`status`,`created_at` FROM movies WHERE status!=-1) ORDER BY created_at DESC LIMIT 16");
        $i=0;
        $j=0;
        $recentFilms=[];
        foreach ($recentFilmAll as $recentFilmline){
            $i++;
            $recentFilms[$j][$i-1-$j*4]=$recentFilmline;
            if($i%4==0){
                $j++;
            }
        }
        $moFilmsAll = Movies::where('status','<>', -1)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        $i=0;
        $j=0;
        $moFilms=[];
        foreach ($moFilmsAll as $moFilmsLine){
            $i++;
            $moFilms[$j][$i-1-$j*4]=$moFilmsLine;
            if($i%4==0){
                $j++;
            }
        }

        /*$shFilmsAll = TvShows::where('status','<>', -1)
            ->where('menu_type',2)
            ->groupBy(['tv_code','seasons'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();*/
        $shFilmsAll = DB::select("SELECT * FROM (SELECT * FROM tv_shows ORDER BY tv_code,created_at DESC) AS a 
                                  WHERE `status`!=-1 AND `menu_type`=2 GROUP BY tv_code,seasons ORDER BY created_at DESC LIMIT 8");
        $i=0;
        $j=0;
        $shFilms=[];
        foreach ($shFilmsAll as $shFilmsLine){
            $i++;
            $shFilms[$j][$i-1-$j*4]=$shFilmsLine;
            if($i%4==0){
                $j++;
            }
        }

        /*$enFilmsAll = TvShows::where('status','<>', -1)
            ->where('menu_type',3)
            ->groupBy(['tv_code','seasons'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();*/
        $enFilmsAll = DB::select("SELECT * FROM (SELECT * FROM tv_shows ORDER BY tv_code,created_at DESC) AS a 
                                 WHERE `status`!=-1 AND `menu_type`=3 GROUP BY tv_code,seasons ORDER BY created_at DESC LIMIT 8");
        $i=0;
        $j=0;
        $enFilms=[];
        foreach ($enFilmsAll as $enFilmsLine){
            $i++;
            $enFilms[$j][$i-1-$j*4]=$enFilmsLine;
            if($i%4==0){
                $j++;
            }
        }

        /*$anFilmsAll = TvShows::where('status','<>', -1)
            ->where('menu_type',0)
            ->groupBy(['tv_code','seasons'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();*/
        $anFilmsAll = DB::select("SELECT * FROM (SELECT * FROM tv_shows ORDER BY tv_code,created_at DESC) AS a 
                                 WHERE `status`!=-1 AND `menu_type`=0 GROUP BY tv_code,seasons ORDER BY created_at DESC LIMIT 8");
        $i=0;
        $j=0;
        $anFilms=[];
        foreach ($anFilmsAll as $anFilmsLine){
            $i++;
            $anFilms[$j][$i-1-$j*4]=$anFilmsLine;
            if($i%4==0){
                $j++;
            }
        }

        return view('films.index',['menu'=>$menu
            ,'areas'=>$areas
            ,'recentFilms'=>$recentFilms
            ,'moFilms'=>$moFilms
            ,'shFilms'=>$shFilms
            ,'enFilms'=>$enFilms
            ,'anFilms'=>$anFilms]);
    }

    protected function showVideo(Request $request){
        $menu = Menu::all();
        $areas = Areas::all();
        $inputArr = $request->all();
        $area = ($request->has('area'))?$inputArr['area']:null;
        $type = ($request->has('type'))?$inputArr['type']:null;
        if($area===''){
            $area = null;
        }
        if($type===''){
            $type = null;
        }
        $start = ($request->has('start'))?$inputArr['start']:0;
        $menuType = $inputArr['menuType'];
        if ($menuType == 1){
            $data = Movies::where('status','<>', -1);
            if($area!==null){
                $data = $data->where('areas', $area);
            }
            if($type!==null){
                $data = $data->where('type', $type);
            }
            $data = $data->orderBy('created_at', 'desc')->skip($start)->take(10)->get();
        }else{
            $subSql = '';
            if ($area!==null){
                $subSql .= " AND areas = $area ";
            }
            if ($type!==null){
                $subSql .= " AND type = $type ";
            }

            $sql = "SELECT * FROM (SELECT * FROM tv_shows WHERE menu_type = $menuType". $subSql ." ORDER BY 
                tv_code,created_at DESC) AS A GROUP BY tv_code,seasons ORDER BY created_at DESC LIMIT $start,10";

            $data = DB::select($sql);
        }

        if($start!=0){
            $newData = [];
            $num = 0;
            foreach ($data as $key=>$val){
                $num++;
                $newData[$key]['code'] = $val->code;
                $newData[$key]['img_url'] = $val->img_url;
                $newData[$key]['menu_type'] = $val->menu_type;
                $newData[$key]['seasons'] = $val->seasons;
                $newData[$key]['en_name'] = $val->en_name;
                $newData[$key]['time'] = $val->time;
                $newData[$key]['name'] = $val->name;
                $newData[$key]['views'] = number_format($val->views);
                $newData[$key]['upload_user'] = $val->upload_user;
            }
            $jsonData = [];
            $jsonData['data'] = $newData;
            $jsonData['num'] = $num;
            echo json_encode($jsonData,JSON_UNESCAPED_UNICODE);
            return;
        }

        $i=0;
        $j=0;
        $newData=[];
        foreach ($data as $value){
            $i++;
            $newData[$j][$i-1-$j*5] = $value;
            if($i%5==0){
                $j++;
            }
        }
        $h2Name = getNameByMenuID($menuType);
        $h2 = ($request->session()->get('lan')=='en'?$h2Name['en_name']:$h2Name['name']);
        $h3Name = ($area===null)?['name'=>'','en_name'=>'']:getNameByAreaCode($area);
        $h3 = ($request->session()->get('lan')=='en'?$h3Name['en_name']:$h3Name['name']);
        return view('films/show',['data'=>$newData,'h2'=>$h2,'h3'=>$h3,'menu'=>$menu,'areas'=>$areas]);
    }
}

<?php

namespace App\Http\Controllers\Films;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Menu;
use App\Areas;

class ShowSingleController extends Controller
{
    protected function index(Request $request){
        $menu = Menu::all();
        $areas = Areas::all();
        $code = Route::input('code');
        $tvOrMovie = (substr($code,0,1)=='M')?true:false;
        if($tvOrMovie){
            $data = DB::table('movies')
                ->where('status','<>',-1)
                ->where('code',$code)
                ->get();
        }else{
            $seasonArr = DB::table('tv_shows')
                ->where('status','<>',-1)
                ->where('code',$code)
                ->select('seasons','tv_code')
                ->get();
            $season = $seasonArr[0]->seasons;
            $tv_code = $seasonArr[0]->tv_code;
            $data = DB::table('tv_shows')
                ->where('status','<>',-1)
                ->where('tv_code',$tv_code)
                ->where('seasons',$season)
                ->orderBy('episodes', 'desc')
                ->get();
        }
        return view('films.single',compact('data','areas','menu'));
    }

    protected function showPlayer(Request $request){
        $mUrl = base64_decode(Route::input('murl'));

        return view('films.player',compact('mUrl'));
    }
}

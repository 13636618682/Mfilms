<?php

namespace App\Http\Controllers\Films;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Menu;
use App\Areas;
use App\YMovies;

class HiddenController extends Controller
{
    protected function index(Request $request)
    {
        $menu = Menu::all();
        $areas = Areas::all();


        $data = YMovies::where('status','<>', -1)
                ->orderBy('created_at', 'desc')
                ->skip(1500)
                ->take(100)
                ->get();
        return view('films.hidden',compact('menu','areas','data'));
    }
}

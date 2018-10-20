<?php

namespace App\Http\Controllers\Films;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class DataController extends Controller
{
    protected function getType(Request $request)
    {
        if(Session::get('lan')=='en'){
            $data = DB::table('style')->pluck('en_name', 'code');
        }else{
            $data = DB::table('style')->pluck('name', 'code');
        }

        echo json_encode($data);
    }
}

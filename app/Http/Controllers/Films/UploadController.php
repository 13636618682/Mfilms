<?php

namespace App\Http\Controllers\Films;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Log;
use App\Menu;
use App\Areas;

class UploadController extends Controller
{
    protected function showUploadForm(){
        $menu = Menu::all();
        $areas = Areas::all();
        return view('films.upload',compact('menu','areas'));
    }

    protected function upload(Request $request)
    {
        $dataInput = $request->input();
        $data = $dataInput['upload'];
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
        ]);

        $img = $request->file('img');
        if(!$img){
            return redirect()->back()->withErrors(['imgError'=>__('请选择电影图片')])->withInput();
        }
         if(!$img->isValid()){
            return redirect()->back()->withErrors(['movieError'=>__('电影图片上传失败')])->withInput();
        }

        $validator->validate();

        //img
        $imgExt = $img->getClientOriginalExtension();
        $imgRealPath = $img->getRealPath();
        $imgName = date('Y-m-d-H-i-s').'-'.uniqid(time()).'.'.$imgExt;
        Storage::disk('uploads')->put($imgName,file_get_contents($imgRealPath));

        $data['img_url'] = env('APP_URL').'/storage/app/uploads/'.$imgName;
        $data['created_at'] = date('y-m-d H:i:s');
        $data['updated_at'] = date('y-m-d H:i:s');

        switch ($data['menu_type']){
            case 0:
                $flag= 'A';
                break;
            case 1:
                $flag= 'M';
                break;
            case 2:
                $flag= 'T';
                break;
            case 3:
                $flag= 'E';
                break;
        }
        $data['code'] = $flag.uniqid(time());
        $data['upload_user'] = auth()->user()->name;
        foreach ($data as $k=>$v){
            if($v===NULL)$data[$k]="";
        }

        if($data['menu_type']==1){
            unset($data['seasons']);
            unset($data['episodes']);
            $dbFlag = DB::table('movies')->insert($data);
        }else{

            $dbFlag = DB::table('tv_shows')->insert($data);
        }

        if($dbFlag){
            return redirect('user/index/'.auth()->id());
        }else{
            return redirect()->back()->withErrors(['dbError'=>'操作失败']);
        }
    }

    protected function uploadsMovie(Request $request){
        $name = $request->get('name');
        $file = $request->file('file');
        if(!$file){
            $array = array('code'=>0);
            echo json_encode($array);
            return;
        }
        $file_blob = file_get_contents($file->getRealPath());

        $pages = $request->get('pages');
        $current_page = $request->get('current_page');

        $ext = trim(substr($name,strpos($name,'.')+1));
        if($ext!='mkv'&&$ext!='swf'&&$ext!='mp4'&&$ext!='rmvb'&&$ext!='ogg'&&$ext!='webm'){
            $array = array('code'=>-1);
            echo json_encode($array);
            return;
        }
        /*if(!$file_blob){
            $array = array('code'=>0);
            echo json_encode($array);
            return;
        }*/

        if($current_page==$pages){
            $mName = date('Y-m-d-H-i-s').uniqid(time()).'.'.$ext;
            for($i=1;$i<$pages;$i++){
                $temp = file_get_contents(storage_path('app/uploads/movies/tmp/part'.$i.'.'.$ext));
                file_put_contents(storage_path('app/uploads/movies/'.$mName),$temp,FILE_APPEND);
                unlink(storage_path('app/uploads/movies/tmp/part'.$i.'.'.$ext));
            }
            file_put_contents(storage_path('app/uploads/movies/'.$mName),$file_blob,FILE_APPEND);
            $array = array('code'=>2,'src'=>env('APP_URL').'/storage/app/uploads/movies/'.$mName);
            echo json_encode($array);
            return;
         }
        Storage::disk('uploadsMoviesTmp')->put('part'.$current_page.'.'.$ext,$file_blob);
        $array = array('code'=>1);
        echo json_encode($array);
        return;
    }

    protected function delDir(){
        deldir(storage_path('app/uploads/movies/tmp/'));
    }
}

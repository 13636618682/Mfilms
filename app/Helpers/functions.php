<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
/**
 * @Description: 通过电影类型名获得其类型编码
 * @parameter string $styleName
 * @return int
 * @author chao
 */
function getFilmsStyleCodeByName($styleName){
    $styleArr = DB::table('style')->pluck('code', 'name');
    foreach ($styleArr as $key=>$val ){
        if($styleName==$key){
            return $styleArr[$styleName];
        }
    }
    return -1;
}

/**
 * @Description: 通过类型编码获得其电影类型名
 * @parameter int $code
 * @return string
 * @author chao
 */
function getFilmsStyleNameByCode($code){
    $styleArr = DB::table('style')->pluck('name', 'code');
    if(array_key_exists($code,$styleArr)){
        return $styleArr[$code];
    }
    return '';
}

/**
 * @Description: 通过menuType id 获取  menuType 名称
 * @parameter int id
 * @return array
 * @author chao
 */
function getNameByMenuID($id){
    $menuArr = DB::table('menu')->get();
    $arr = [];
    foreach ($menuArr as $val){
        if($val->id==$id){
            $arr['name'] = $val->name;
            $arr['en_name'] = $val->en_name;
            return $arr;
        }
    }
}

/**
 * @Description: 通过area code 获取  area 名称
 * @parameter int code
 * @return array
 * @author chao
 */
function getNameByAreaCode($code){
    $areaArr = DB::table('areas')->get();
    $arr = [];
    foreach ($areaArr as $val){
        if($val->code==$code){
            $arr['name'] = $val->name;
            $arr['en_name'] = $val->en_name;
            return $arr;
        }
    }
}

/**
 * @Description: 通过 area 名称 获取 area code
 * @parameter string
 * @return int
 * @author chao
 */
function getCodeByAreaName($name){
    $areaArr = DB::table('areas')->pluck('code', 'name');
    if($name=='日本'||$name=='韩国'){
        return 3;
    }
    if($name=='香港'||$name=='台湾'){
        return 2;
    }
    foreach ($areaArr as $key=>$val ){
        if($name==$key){
            return $areaArr[$name];
        }
    }
    return 4;
}


//清空文件夹函数和清空文件夹后删除空文件夹函数的处理
function deldir($path){
    //如果是目录则继续
    if(is_dir($path)){
        //扫描一个文件夹内的所有文件夹和文件并返回数组
        $p = scandir($path);
        foreach($p as $val){
            //排除目录中的.和..
            if($val !="." && $val !=".."){
                //如果是目录则递归子目录，继续操作
                if(is_dir($path.$val)){
                    //子目录中操作删除文件夹和文件
                    deldir($path.$val.'/');
                    //目录清空后删除空文件夹
                    @rmdir($path.$val.'/');
                }else{
                    //如果是文件直接删除
                    unlink($path.$val);
                }
            }
        }
    }
}


























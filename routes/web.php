<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware'=>'web'],function (){
    Route::group(['middleware'=>'locale'],function (){
        Route::any('films/index', 'Films\ShowHomeController@index');
        Route::any('films/player/{murl}','Films\ShowSingleController@showPlayer');
        Route::any('films/show','Films\ShowHomeController@showVideo');
        Route::any('films/single/{code}','Films\ShowSingleController@index');
        Route::any('films/data','Films\DataController@getType');
        Route::any('films/search','Films\SearchController@index');
        Route::any('films/hidden','Films\HiddenController@index');
        Route::get('films/upload','Films\UploadController@showUploadForm');
        Route::post('films/upload','Films\UploadController@upload');
        Route::any('films/uploadsMovie','Films\UploadController@uploadsMovie');
        Route::any('films/delDir','Films\UploadController@delDir');
        //
        Route::any('user/register','Auth\RegisterController@register');
        Route::any('user/login','Auth\LoginController@login');
        Route::any('user/logout','Auth\LoginController@logout');
        Route::any('user/index/{id}','Auth\UserInfoController@index');
        Route::any('user/sendEmail','Auth\SendEmailController@sendEmail');
    });
});



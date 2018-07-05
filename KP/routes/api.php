<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//分类
Route::prefix('categories')->group(function () {
    Route::any('/','CategoryController@lists');
    Route::any('models','CategoryController@models');
    Route::any('pages','CategoryController@pages');
    Route::any('add/model','CategoryController@addModel');
    Route::any('add/page','CategoryController@addPage');
    Route::any('delete/category/{category}','CategoryController@deleteCategory');
});

//类型
Route::prefix('kptypes')->group(function () {
    Route::any('/','KptypeController@lists');
    Route::any('lists','KptypeController@getLists');
});

//来源
Route::prefix('titles')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::any('lists','TitleController@getLists');
    Route::post('add','TitleController@addTitle');
    Route::post('update','TitleController@updateTitle');
    Route::post('delete/{title}','TitleController@deleteTitle');

});
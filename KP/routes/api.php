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

//规范名
Route::prefix('standard')->group(function () {
    Route::any('/','StandardController@lists');
    Route::any('lists','StandardController@getLists');
    Route::post('add','StandardController@addStandard');
    Route::post('update','StandardController@updateStandard');
    Route::post('delete/{standard}','StandardController@deleteStandard');

});

//章节
Route::prefix('title')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::any('create','TitleController@createTitle');
    Route::any('lists','TitleController@getLists');
    Route::post('add','TitleController@addTitle');
    Route::post('update','TitleController@updateTitle');
    Route::post('delete/{title}','TitleController@deleteTitle');
    Route::any('content/{title}','TitleController@getContent');
    Route::any('sentences/{title}','TitleController@getSentences');
    Route::any('tags/{title}','TitleController@getTags');

});



//分词
Route::prefix('word')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::any('tags','WordController@getTags');

});

//标签
Route::prefix('content')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::any('save','ContentController@saveContent');

});


//标签
Route::prefix('tag')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::any('save','TagController@saveTags');

});
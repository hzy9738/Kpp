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
    Route::post('/','CategoryController@lists');
    Route::post('models','CategoryController@models');
    Route::post('pages','CategoryController@pages');

    Route::any('models/clear','CategoryController@modelsClear');
    Route::any('pages/clear','CategoryController@pagesClear');
    Route::post('add/model','CategoryController@addModel');
    Route::post('add/page','CategoryController@addPage');
    Route::post('delete/category','CategoryController@deleteCategory');
    Route::post('from/to','CategoryController@fromTo');
});

//类型
Route::prefix('kptypes')->group(function () {
    Route::post('/','KptypeController@lists');
    Route::post('lists','KptypeController@getLists');
    Route::post('index/list','KptypeController@indexList');
//    Route::post('add','KptypeController@addType');
//    Route::any('update','KptypeController@updateType');
//    Route::any('delete','KptypeController@deleteType');
});

//规范名
Route::prefix('standard')->group(function () {
    Route::post('/','StandardController@lists');
    Route::post('lists','StandardController@getLists');
    Route::post('add','StandardController@addStandard');
    Route::post('update','StandardController@updateStandard');
    Route::post('delete','StandardController@deleteStandard');
    Route::get('watch','StandardController@watchStandard');
});

//章节
Route::prefix('title')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::post('create','TitleController@createTitle');
    Route::post('lists','TitleController@getLists');
    Route::post('add','TitleController@addTitle');
    Route::post('update','TitleController@updateTitle');
    Route::post('delete','TitleController@deleteTitle');
    Route::post('content','TitleController@getContent');
    Route::post('sentences','TitleController@getSentences');
//    Route::post('tags','TitleController@getTags');

});



//分词
Route::prefix('word')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::post('tags','WordController@getTags');

});

//内容
Route::prefix('content')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::post('save','ContentController@saveContent');

});


//标签
Route::prefix('tag')->group(function () {
//    Route::any('/','KptypeController@getLists');
//    Route::any('save','TagController@saveTags');

});


//查找
Route::prefix('search')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::post('category','SearchController@category');
    Route::post('keyword','SearchController@keyword');
    Route::post('content','SearchController@content');


    Route::post('result','SearchController@result');


//    Route::any('scout','SearchController@scout');
//    Route::any('mysql','SearchController@mysql');
});

//结果集
Route::prefix('result')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::post('save/page','ResultController@savePage');
//    Route::any('export/keyword','ExcelController@excelKeywordExport');

});

//标签
Route::prefix('excel')->group(function () {
//    Route::any('/','KptypeController@getLists');
    Route::get('export','ExcelController@excelExport');
//    Route::any('export/keyword','ExcelController@excelKeywordExport');

});
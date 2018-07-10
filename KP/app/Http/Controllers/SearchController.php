<?php

namespace App\Http\Controllers;

use App\Model\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function keyword(Request $request)
    {
        $keyword  = $request->input('keyword');
        $data =  Tag::where('tag','like',"%{$keyword}%")->get();
        return responseJson($data);
    }


    public function category(Request $request)
    {

    }
}

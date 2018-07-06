<?php

namespace App\Http\Controllers;

use App\Http\Validate\ContentValidate;
use App\Model\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function saveContent(Request $request){
        $result =  ContentValidate::validate($request);
        if($result['msg']){
            $result = Content::saveContent($request);
        }
        return responseJson($result);
    }
}

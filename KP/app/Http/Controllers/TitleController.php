<?php

namespace App\Http\Controllers;

use App\Http\Validate\TitleValidate;
use App\Model\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function getLists()
    {
        $data = validateData(
            Title::orderBy('id','desc')->with('types')->paginate(10)
        );
        return responseJson($data);
    }

    public function addTitle(Request $request)
    {
        $result = TitleValidate::validate($request);
        if($result['msg']){
            $result = Title::addTitle($request);
        }
        return responseJson($result);
    }

    public function updateTitle(Request $request){
        $result = TitleValidate::update($request);
        if($result['msg']){
            $result = Title::updateTitle($request);
        }
        return responseJson($result);
    }


    public function deleteTitle(Title $title){
        $data = validateData(
            $title->delete()
        );
        return responseJson($data);
    }
}

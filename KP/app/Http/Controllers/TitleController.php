<?php

namespace App\Http\Controllers;

use App\Http\Validate\TitleValidate;
use App\Model\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function createTitle(Request $request){
        $data = Title::createTitle($request);
        return responseJson($data);
    }

    public function getLists(Request $request)
    {
        $data = Title::lists($request);
        return responseJson($data);
    }

    public function addTitle(Request $request)
    {
        $result = TitleValidate::validate($request);
        if($result['msg'] === config('code.success')){
            $result = Title::addTitle($request);
        }
        return responseJson($result);
    }

    public function updateTitle(Request $request){
        $result = TitleValidate::update($request);
        if($result['msg'] === config('code.success')){
            $result = Title::updateTitle($request);
        }
        return responseJson($result);
    }


    public function deleteTitle(Title $title){
        $result = Title::deleteTitle($title);
        return responseJson($result);
    }

    public function getContent(Title $title){
        $data = validateData(
            $title->load('detail')
        );
        return responseJson($data);
    }

    public function getTags(Title $title){
        $data = validateData(
            $title->load('tags')
        );
        return responseJson($data);
    }

    public function getSentences(Title $title){
        $data = Title::getSentences($title);
        return responseJson($data);
    }
}

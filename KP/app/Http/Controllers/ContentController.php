<?php

namespace App\Http\Controllers;

use App\Http\Validate\ContentValidate;
use App\Model\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * @Name 保存章节内容
     * @Description 保存章节内容
     * @Param title:  章节ID
     * @Param content:  章节内容
     * @Param sentences:  简述
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function saveContent(Request $request){
        $result =  ContentValidate::validate($request);
        ddJson($request->all());
        if($result['msg'] === config('code.success')){
            $result = Content::saveContent($request);
        }
        return responseJson($result);
    }
}

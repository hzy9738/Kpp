<?php

namespace App\Http\Controllers;

use App\Http\Validate\TitleValidate;
use App\Model\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    /**
     * @Name 创建章节
     * @Description 创建章节
     * @Param standard:  规范ID
     * @Param title:   章节名称
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function createTitle(Request $request)
    {
        $data = Title::createTitle($request);
        return responseJson($data);
    }

    /**
     * @Name 章节列表
     * @Description 章节列表
     * @Param id:  规范ID
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function getLists(Request $request)
    {
        $id = $request->input('id');

        $id = isset($id) ? $id : -1;

        $data = Title::lists($id);
        return responseJson($data);
    }

    /**
     * @Name 添加子章节
     * @Description 章节列表
     * @Param title:   章节名称
     * @Param id:  上级章节ID
     * @Param level:  章节层级
     * @Param standard:  规范ID
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function addTitle(Request $request)
    {
        $result = TitleValidate::validate($request);
        if ($result['msg'] === config('code.success')) {
            $result = Title::addTitle($request);
        }
        return responseJson($result);
    }

    /**
     * @Name 修改章节
     * @Description 修改章节接口
     * @Param title:   章节名称
     * @Param id:  章节ID
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function updateTitle(Request $request)
    {
        $result = TitleValidate::update($request);
        if ($result['msg'] === config('code.success')) {
            $result = Title::updateTitle($request);
        }
        return responseJson($result);
    }

    /**
     * @Name 删除章节
     * @Description 删除章节
     * @Param id:  章节ID
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function deleteTitle(Request $request)
    {
        $id = $request->input('id', 0);
        $result = Title::deleteTitle($id);
        return responseJson($result);
    }

    /**
     * @Name 章节详情内容
     * @Description 章节详情内容
     * @Param id:  章节ID
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function getContent(Request $request)
    {
        $id = $request->input('id', 0);
        $title = Title::find($id);
        $data = validateData(
            $title->load('detail')
        );
        return responseJson($data);
    }

    /**
     * @Name 章节Tag
     * @Description 获取相关的章节Tag
     * @Param id:  章节ID
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function getTags(Request $request)
    {
        $id = $request->input('id', 0);
        $title = Title::find($id);
        $data = validateData(
            $title->load('tags')
        );
        return responseJson($data);
    }

    /**
     * @Name 章节简述
     * @Description 获取相关的章节简述
     * @Param id:  章节ID
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function getSentences(Request $request)
    {
        $id = $request->input('id', 0);
        $title = Title::find($id);
        $data = Title::getSentences($title);
        return responseJson($data);
    }
}

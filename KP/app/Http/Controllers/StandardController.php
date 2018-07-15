<?php

namespace App\Http\Controllers;

use App\Http\Validate\StandardValidate;

use App\Model\Standard;

use Illuminate\Http\Request;

class StandardController extends Controller
{
    /**
     * @Name 规范列表
     * @Description 规范列表
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          [
     *           "id":21,
     *           "type_id":2,
     *           "name":"综合医院建筑设计规范",
     *           "types":{
     *           "id":2,
     *           "name":"国家规范",
     *           "weigh":6,
     *           "status":"1"
     *            }
     *      ],
     *      ...
     *      },
     *     "message":"success"
     * }
     */
    public function lists()
    {
        $data = validateData(
            Standard::orderBy('id', 'desc')->with('types')->get()
        );
        return responseJson($data);
    }

    /**
     * @Name 规范分类分页
     * @Description 删除分类
     * @Param page: 页码 （默认1）
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          "current_page":1,
     *          "data":[
     *              {
     *                "id":21,
     *                "type_id":2,
     *                "name":"综合医院建筑设计规范",
     *                "types":{
     *                "id":2,
     *                "name":"国家规范",
     *                "weigh":6,
     *                "status":"1"
     *             }
     *           ...
     *           }
     *           ],
     *        "first_page_url":"http://kp.com/api/standard/lists?page=1",
     *        "from":1,
     *        "last_page":1,
     *        "last_page_url":"http://kp.com/api/standard/lists?page=1",
     *        "next_page_url":null,
     *        "path":"http://kp.com/api/standard/lists",
     *        "per_page":10,
     *        "prev_page_url":null,
     *        "to":10,
     *        "total":10
     *      },
     *     "message":"success"
     * }
     */
    public function getLists(Request $request)
    {
        $page = $request->input('page',1);
        $data = validateData(
            Standard::orderBy('id', 'desc')->with('types')->paginate(10,['*'],'page',$page)
        );
        return responseJson($data);
    }


    /**
     * @Name 添加规范
     * @Description 添加规范 （规范 === 知识点来源）
     * @Param name: 规范名称
     * @Param type: 类型ID
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function addStandard(Request $request)
    {
        $result = StandardValidate::validate($request);
        if($result['msg'] === config('code.success')){
            $result = Standard::addStandard($request);
        }
        return responseJson($result);
    }
    /**
     * @Name 修改规范
     * @Description 修改规范 （规范 === 知识点来源）
     * @Param id:   规范ID
     * @Param name: 规范名称
     * @Param type: 类型ID
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function updateStandard(Request $request)
    {
        $result = StandardValidate::update($request);
        if($result['msg'] === config('code.success')){
            $result = Standard::updateStandard($request);
        }
        return responseJson($result);
    }

    /**
     * @Name 删除规范
     * @Description 删除规范 （规范 === 知识点来源）
     * @Param id:   规范ID
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function deleteStandard(Request $request)
    {
        $id = $request->input('id',0);
        $result = StandardValidate::validateDelete($id);
        if($result['msg'] === config('code.success')){
            $standard = Standard::find($id);
            $result = validateData(
                $standard->delete()
            );
        }
        return responseJson($result);
    }
}

<?php

namespace App\Http\Controllers;

use App\Model\Kptype;
use Illuminate\Http\Request;

class KptypeController extends Controller
{
    /**
     * @Name 类型列表1
     * @Description 类型列表
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":[
     *       {
     *           "id":1,
     *           "name":"强制规范",
     *           "weigh":10,
     *           "status":"1"
     *        },
     *        ...
     * ],
     *     "message":"success"
     * }
     */
    public function lists()
    {
        $data = validateData(
            Kptype::orderBy('id')->get()
        );
        return responseJson($data);
    }


    /**
     * @Name 类型列表2
     * @Description 类型列表,以id为下标
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":[
     *       {
     *           "id":1,
     *           "name":"强制规范",
     *           "weigh":10,
     *           "status":"1"
     *        },
     *        ...
     * ],
     *     "message":"success"
     * }
     */
    public function indexList()
    {
        $data = validateData(
            Kptype::orderBy('id')->pluck('name','id')
        );
        return responseJson($data);
    }
    /**
     * @Name 类型分页列表
     * @Description 类型列表分页
     * @Param page: 页码 （默认1）
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":[
     *       {
     *        "current_page":1,
     *              "data":[
     *                  {
     *                      "id":1,
     *                      "name":"强制规范",
     *                      "weigh":10,
     *                      "status":"1"
     *                   },
     *                  ...
     *               ],
     *          "first_page_url":"http://kp.com/api/kptypes/lists?page=1",
     *          "from":1,
     *          "last_page":1,
     *          "last_page_url":"http://kp.com/api/kptypes/lists?page=1",
     *          "next_page_url":null,
     *          "path":"http://kp.com/api/kptypes/lists",
     *          "per_page":15,
     *          "prev_page_url":null,
     *          "to":6,
     *          "total":6
     *      }
     * ],
     *     "message":"success"
     * }
     */
    public function getLists(Request $request)
    {
        $page = $request->input('page',1);
        $data = validateData(
            Kptype::orderBy('id')->paginate(10,['*'],'page',$page)
        );
        return responseJson($data);
    }

}

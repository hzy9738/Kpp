<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Validate\CategoryValidate;
use App\Model\Category;
use App\Model\Sentence;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * @Name 分类合集
     * @Description 分类合集接口，包括标准和知识点
     *
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *      data{
     *          id: title
     *      }
     * }
     */
    public function lists()
    {
        $data = Category::lists();
        return responseJson($data);
    }


    /**
     * @Name 标准分类
     * @Description 标准分类接口
     *
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *   data{
     *     "code":1,
     *      data{
     *           id:"标准分类id",
     *           pid:"父id",
     *           title: "标准分类名称"
     *           type: "分类类型"
     *           status: "状态"
     *           model_child: : [
     *                {
     *                   id:"标准分类id",
     *                   pid:"父id",
     *                   title: "标准分类名称"
     *                   type: "分类类型"
     *                   status: "状态"
     *                   model_child: : []
     *              }
     *           ]
     *      }
     * }
     */
    public function models()
    {
        $data = Category::models();
        return responseJson($data);
    }


    /**
     * @Name 简洁标准分类
     * @Description 标准分类接口
     *
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *   data{
     *     "code":1,
     *      data{
     *           title: "标准分类名称"
     *           model_child: : [
     *                {
     *                   title: "标准分类名称"
     *                   model_child: : []
     *              }
     *           ]
     *      }
     * }
     */
    public function modelsClear(){
        $data = Category::models();
        $list = Category::clearList($data['data']);
        return ddJson($list);
    }

    /**
     * @Name 知识点分类
     * @Description 知识点分类接口
     *
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *   data{
     *     "code":1,
     *      data{
     *           id:"知识点分类id",
     *           pid:"父id",
     *           title: "知识点分类名称"
     *           type: "分类类型"
     *           status: "状态"
     *           model_child: : [
     *              {
     *                   id:"知识点分类id",
     *                   pid:"父id",
     *                   title: "知识点分类名称"
     *                   type: "分类类型"
     *                   status: "状态"
     *                   model_child: : []
     *              }
     *        ]
     *      }
     * }
     */
    public function pages()
    {
        $data = Category::pages();
        return responseJson($data);
    }

    /**
     * @Name 简洁知识点分类
     * @Description 标准分类接口
     *
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *   data{
     *     "code":1,
     *      data{
     *           title: "标准分类名称"
     *           model_child: : [
     *                {
     *                   title: "标准分类名称"
     *                   model_child: : []
     *              }
     *           ]
     *      }
     * }
     */
    public function pagesClear(){
        $data = Category::pages();
        $list = Category::clearList($data['data']);
        return ddJson($list);
    }



    /**
     * @Name 添加标准分类
     * @Description 添加标准分类
     * @Param name: 分类名称
     * @Param id: 父级id
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *           "pid":"1",
     *           "name":"文档",
     *           "type":"default",
     *           "status":"normal",
     *           "createtime":1531634276,
     *           "updatetime":1531634276,
     *           "id":159
     *     },
     *    "message":"success"
     * }
     */
    public function addModel(Request $request)
    {
        $result = CategoryValidate::validate($request);
        if ($result['msg'] === config('code.success')) {
            $result = Category::addModel($request);
        }
        return responseJson($result);
    }

    /**
     * @Name 添加知识点分类
     * @Description 添加知识点分类
     * @Param name: 分类名称
     * @Param id: 父级id
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *           "pid":"1",
     *           "name":"文档",
     *           "type":"page",
     *           "status":"normal",
     *           "createtime":1531634276,
     *           "updatetime":1531634276,
     *           "id":159
     *     },
     *    "message":"success"
     * }
     */
    public function addPage(Request $request)
    {
        $result = CategoryValidate::validate($request);
        if ($result['msg'] === config('code.success')) {
            $result = Category::addPage($request);
        }
        return responseJson($result);
    }


    /**
     * @Name 删除分类
     * @Description 删除分类
     * @Param id: 分类id
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":1,
     *     "message":"success"
     * }
     */
    public function deleteCategory(Request $request)
    {
        $id = $request->input('id', 0);
        $result = CategoryValidate::validateDelete($id);
        if ($result['msg'] === config('code.success')) {
            $category = Category::find($id);
            $result = Category::deleteCategory($category);
        }
        return responseJson($result);
    }


    public function fromTo(Request $request)
    {
        $type = $request->input('type', 'page');
        $from = $request->input('form', []);
        $to = $request->input('to', []);
        $from = implode(',', $from);
        $to = implode(',', $to);


        if ($type == 'page') {
            $data = validateData(
                Sentence::where('page_id', $from)->update(['page_id' => $to])
            );
        } else {
            $data = validateData(
                Sentence::where('model_id', $from)->update(['model_id' => $to])
            );
        }
        return responseJson($data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Validate\StandardValidate;

use App\Model\Standard;

use App\Model\Title;
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

            $result = validateData(
                Standard::deleteStandard($id)
            );
        }
        return responseJson($result);
    }





    public function watchStandard(Request $request)
    {
        $id = $request->input('id');
        $result = validateData(
            Standard::watchStandard($id)
        );

        if($result['msg'] == 1){
            $data = $result['data'];
            $pdf = new \TCPDF();
            // 设置文档信息
            $pdf->SetCreator('Hello world');
            $pdf->SetAuthor('dyk');
            $pdf->SetTitle('TCPDF示例');
            $pdf->SetSubject('TCPDF示例');
            $pdf->SetKeywords('TCPDF, PDF, PHP');

            // 设置页眉和页脚信息
            $pdf->SetHeaderData('', 0, 'www.Bimeng.com', '彼盟科技！', [0, 64, 255], [0, 64, 128]);
            $pdf->setFooterData([0, 64, 0], [0, 64, 128]);

            // 设置页眉和页脚字体
            $pdf->setHeaderFont(['stsongstdlight', '', '10']);
            $pdf->setFooterFont(['helvetica', '', '8']);

            // 设置默认等宽字体
            $pdf->SetDefaultMonospacedFont('courier');

            // 设置间距
            $pdf->SetMargins(15, 15, 15);//页面间隔
            $pdf->SetHeaderMargin(5);//页眉top间隔
            $pdf->SetFooterMargin(10);//页脚bottom间隔

            // 设置分页
            $pdf->SetAutoPageBreak(true, 25);

            // 设置自动换页
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // 设置图像比例因子
            $pdf->setImageScale(1.25);

            // 设置默认字体构造子集模式
            $pdf->setFontSubsetting(true);

            // 设置字体 stsongstdlight支持中文
            $pdf->SetFont('stsongstdlight', '', 14);

            // 添加一页
            $pdf->AddPage();

            $pdf->Ln(5);//换行符

            $html =  $data;

            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('t.pdf', 'I');//I输出、D下载

        }
        return responseJson($result);

    }
}

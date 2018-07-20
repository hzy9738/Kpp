<?php

namespace App\Http\Controllers;

use App\Excel;
use App\Model\Category;
use App\Model\Export;
use App\Model\Tag;
use Illuminate\Http\Request;


class ExcelController extends Controller
{



    /**
     * @Name Excel表格导出
     * @Description Excel表格导出接口
     * @Param type:  搜索方式 keyword->Tag搜索  category->标准类型  content->全文搜索
     * @Param keyword:  Tag or 标准 or 内容关键字 
     * @Param splices:  删除的行
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */

    public function excelExport(Request $request)
    {
        $type = $request->input('type', 'keyword');
        $keyword = $request->input('keyword', '');
        if ($type == 'category') {
            $keyword = explode(',', $keyword);
            $array = self::keywordFormdata($keyword);
        }
        $pageSize = $request->input('pageSize', 10);
        $splices = $request->input('splices','');
        $splices = explode(',',$splices);
         if(isset($splices[0])){
             unset($splices[0]);
         }
//        dd($splices);
        if ($type == 'category') {
            $data = validateData(
                Tag::orderBy('tag.id', 'desc')
                    ->leftJoin('sentence_tag', 'sentence_tag.tag_id', 'tag.id')
                    ->leftJoin('sentence', 'sentence_tag.sentence_id', 'sentence.id')
                    ->leftJoin('content', 'sentence.content_id', 'content.id')
                    ->leftJoin('title', 'content.title_id', 'title.id')
                    ->leftJoin('standard', 'title.standard_id', 'standard.id')
                    ->leftJoin('kptype', 'standard.type_id', 'kptype.id')
                    ->whereNotNull('sentence.sentence')
                    ->whereIn('sentence.model_id', $array)
                    ->select('tag.id', 'tag', 'sentence', 'content', 'sentence.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard')
                    ->paginate($pageSize)
            );
        }elseif ($type == 'content') {
            $data = validateData(
                Tag::orderBy('tag.id', 'desc')
                    ->leftJoin('sentence_tag', 'sentence_tag.tag_id', 'tag.id')
                    ->leftJoin('sentence', 'sentence_tag.sentence_id', 'sentence.id')
                    ->leftJoin('content', 'sentence.content_id', 'content.id')
                    ->leftJoin('title', 'content.title_id', 'title.id')
                    ->leftJoin('standard', 'title.standard_id', 'standard.id')
                    ->leftJoin('kptype', 'standard.type_id', 'kptype.id')
                    ->whereNotNull('sentence.sentence')
                    ->where('content.content', 'like', "%{$keyword}%")
                    ->select('tag.id', 'tag', 'sentence', 'content', 'sentence.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard')
                    ->paginate($pageSize)
            );
        }

        elseif ($type == 'keyword') {
            $data = validateData(
                Tag::orderBy('tag.id', 'desc')
                    ->leftJoin('sentence_tag', 'sentence_tag.tag_id', 'tag.id')
                    ->leftJoin('sentence', 'sentence_tag.sentence_id', 'sentence.id')
                    ->leftJoin('content', 'sentence.content_id', 'content.id')
                    ->leftJoin('title', 'content.title_id', 'title.id')
                    ->leftJoin('standard', 'title.standard_id', 'standard.id')
                    ->leftJoin('kptype', 'standard.type_id', 'kptype.id')
                    ->whereNotNull('sentence.sentence')
                    ->where('tag.tag', 'like', "%{$keyword}%")
                    ->select('tag.id', 'tag', 'sentence', 'content', 'sentence.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard')
                    ->paginate($pageSize)
            );
        }
        elseif ($type == 'result') {
            $data = validateData(
            Export::orderBy('id','desc')
                ->where('name',$keyword)
                ->select('name','tag','sentence','content','standard','model','page','user','type','sentence_id','kown_id','type_id','model_id')
                ->distinct()
                ->paginate($pageSize)
            );
        }


        $category = Category::orderBy('id')->pluck('name', 'id');

        if (!$data['msg']) {
            return false;
        }
        $exports = [];
        if($type == 'result'){

            foreach ($data['data'] as $key => $item) {

                if(!in_array($key,$splices)){
                    $exports[$key]['index'] = $key + 1;
                    $exports[$key]['tag'] = $item->tag;
                    $exports[$key]['sentence'] = $item->sentence;
                    $exports[$key]['content'] = $item->content;
                    $exports[$key]['standard'] = $item->standard;
                    $exports[$key]['modelItem'] =  $item->model;
                    $exports[$key]['pageItem'] =  $item->page;
                    $exports[$key]['user'] = $item->user;
                    $exports[$key]['type'] = $item->type;
                    $exports[$key]['kownId'] = '';
                    $exports[$key]['typeId'] = 23;
                    $exports[$key]['modelId'] = '';
                  }
            }
        }else{
            foreach ($data['data'] as $key => $item) {
                if(!in_array(0,$splices)){
                    $modelItem = '';
                    $pageItem = '';
                    if ($item->model_id != '') {
                        $models = explode(',', $item->model_id);
                        $modelItem = [];
                        foreach ($models as $model) {
                            if(isset($category[$model])){
                                $modelItem[] = $category[$model];
                            }
                        }
                        $modelItem = implode(' / ', $modelItem);
                    }
                    if ($item->page_id != '') {
                        $pages = explode(',', $item->page_id);
                        $pageItem = [];
                        foreach ($pages as $page) {
                            if(isset($category[$page])){
                                $pageItem[] =$category[$page];
                            }
                        }
                        $pageItem = implode(' / ', $pageItem);
                    }

                    $exports[$key]['index'] = $key + 1;
                    $exports[$key]['tag'] = $item->tag;
                    $exports[$key]['sentence'] = $item->sentence;
                    $exports[$key]['content'] = $item->content;
                    $exports[$key]['standard'] = $item->standard;
                    $exports[$key]['modelItem'] = $modelItem;
                    $exports[$key]['pageItem'] = $pageItem;
                    $exports[$key]['user'] = $item->user;
                    $exports[$key]['type'] = $item->type;
                    $exports[$key]['kownId'] = '';
                    $exports[$key]['typeId'] = 23;
                    $exports[$key]['modelId'] = '';
                }
            }
        }

        $width = [
            'A' => 10,
            'B' => 30,
            'C' => 40,
            'D' => 100,
            'E' => 30,
            'F' => 30,
            'G' => 30,
//            'I' => 10,
//            'J' => 30,
        ];

        $excelName = 'kp-标准分类查询';
        $row = ['序号', 'tag', '简述', '详细说明', '来源', '分类', '阶段', '收集人', '知识点类型', '分类ID', '分类ID', '模型ID'];

        $count = count($row);


        Excel::export($excelName, $row, $exports, $width, $count);
    }


    public static function keywordFormdata($keyword)
    {
        $array = [];
        foreach ($keyword as $key => $item) {
            if ($key >= 1) {
                $array[$key] = $array[$key - 1] . "," . $item;
            } else {
                $array[0] = "{$item}";
            }
        }
        return $array;
    }


}

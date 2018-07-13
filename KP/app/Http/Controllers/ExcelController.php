<?php

namespace App\Http\Controllers;

use App\Excel;
use App\Model\Category;
use App\Model\Tag;
use Illuminate\Http\Request;


class ExcelController extends Controller
{
    public function excelExport(Request $request)
    {
        $type = $request->input('type', 'keyword');
        $keyword = $request->input('keyword', '');
        if ($type == 'category') {
            $keyword = explode(',', $keyword);
            $array = self::keywordFormdata($keyword);
        }
        $pageSize = $request->input('pageSize', 10);

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

        else{
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

        $category = Category::orderBy('id')->pluck('name', 'id');

        if (!$data['msg']) {
            return false;
        }
        $exports = [];
        foreach ($data['data'] as $key => $item) {
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

        $width = [
            'A' => 10,
            'B' => 10,
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

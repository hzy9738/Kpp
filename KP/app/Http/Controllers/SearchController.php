<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Sentence;
use App\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SearchController extends Controller
{

    /**
     * @Name 关键词Tag搜索
     * @Description 关键词Tag搜索接口
     * @Param keyword:  关键词Tag
     * @Param page:  页码（默认1）
     * @Param pageSize:  每页条数（默认10）
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function keyword(Request $request)
    {
        $keyword = $request->input('keyword');
        $pageSize = $request->input('pageSize', 10);
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
                ->select('tag.id','sentence.id as sentence_id', 'tag', 'sentence', 'content', 'sentence.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard')
                ->paginate($pageSize)
        );
        return responseJson($data);
    }

    /**
     * @Name 标准分类搜索
     * @Description 标准分类搜索接口
     * @Param keyword:  标准分类
     * @Param page:  页码（默认1）
     * @Param pageSize:  每页条数（默认10）
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function category(Request $request)
    {
        $keyword = $request->input('keyword');
        $pageSize = $request->input('pageSize', 10);
        $array = self::keywordFormdata($keyword);
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
                ->select('tag.id','sentence.id as sentence_id', 'tag', 'sentence', 'content', 'sentence.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard')
                ->paginate($pageSize)
        );
        return responseJson($data);
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


    /**
     * @Name 全文搜索
     * @Description 全文搜索接口
     * @Param keyword: 章节内容关键字
     * @Param page:  页码（默认1）
     * @Param pageSize:  每页条数（默认10）
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function content(Request $request){
        $keyword = $request->input('keyword');
        $pageSize = $request->input('pageSize', 10);
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
                ->select('tag.id', 'sentence.id as sentence_id','tag', 'sentence', 'content', 'sentence.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard')
                ->paginate($pageSize)
        );
        return responseJson($data);
    }
}

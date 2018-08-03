<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Export;
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


        Sentence::orderBy('sentence.id', 'desc')
            ->leftJoin('kptype', 'sentence.type', 'kptype.id')
            ->leftJoin('content', 'sentence.content_id', 'content.id')
            ->leftJoin('title', 'content.title_id', 'title.id')
            ->leftJoin('standard', 'title.standard_id', 'standard.id')
//            ->with(['tags'=>function($query) use($keyword){
//                $query->where('tag', 'like', "%{$keyword}%")
//
//                ;
//            }])
            ->whereHas('tags', function($query) use($keyword)
            {
                $query->where('tag', 'like', "%{$keyword}%");
            })
            ->select('sentence.id', 'sentence', 'content', 'standard.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard')
            ->whereNotNull('sentence.sentence')
            ->where('sentence.import',1)
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


            Sentence::orderBy('sentence.id', 'desc')
                ->leftJoin('kptype', 'sentence.type', 'kptype.id')
                ->leftJoin('content', 'sentence.content_id', 'content.id')
                ->leftJoin('title', 'content.title_id', 'title.id')
                ->leftJoin('standard', 'title.standard_id', 'standard.id')
                ->with(['tags'=>function($query) use($keyword){}])
                ->select('sentence.id', 'sentence', 'content', 'standard.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard')
                ->whereNotNull('sentence.sentence')
                ->where('sentence.import',1)
                ->whereIn('sentence.model_id', $array)
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
            Sentence::orderBy('sentence.id', 'desc')
                ->leftJoin('kptype', 'sentence.type', 'kptype.id')
                ->leftJoin('content', 'sentence.content_id', 'content.id')
                ->leftJoin('title', 'content.title_id', 'title.id')
                ->leftJoin('standard', 'title.standard_id', 'standard.id')
                ->with(['tags'=>function($query) use($keyword){}])
                ->select('sentence.id', 'sentence', 'content', 'standard.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard')
                ->whereNotNull('sentence.sentence')
                ->where('content.content', 'like', "%{$keyword}%")
                ->where('sentence.import',1)
                ->paginate($pageSize)
        );
        return responseJson($data);
    }



    /**
     * @Name 获取结果集
     * @Description 获取结果集接口
     * @Param name: 结果集id
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function result(Request $request){
        $today = strtotime(date('Y-m-d'));
        Export::where('createtime','<',$today)->delete();
        $name = $request->input('name');
        $pageSize = $request->input('pageSize', 10);
        $data = validateData(
                Export::orderBy('id','desc')
                    ->where('name',$name)
                    ->select('name','tag','sentence','content','standard','model','page','user','type','sentence_id','kown_id','type_id','model_id')
                    ->distinct()
//                    ->groupBy('id','name','tag','sentence','content','standard','model','page','user','type','sentence_id','kown_id','type_id','model_id','createtime')
                ->paginate($pageSize)
        );
        return responseJson($data);

    }


    public function savePageResult(Request $request){
        return 1;
    }
}

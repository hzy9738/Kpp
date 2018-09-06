<?php

namespace App\Http\Controllers;

use App\Excel;
use App\Model\Category;
use App\Model\Content;
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


        Sentence::orderBy('sentence.level', 'desc')
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


            Sentence::orderBy('sentence.level', 'desc')
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
    public function system(Request $request)
    {
        $keyword = $request->input('keyword');
        $pageSize = $request->input('pageSize', 10);
        $array = self::keywordFormdata($keyword);
        $data = validateData(


            Sentence::orderBy('sentence.level', 'desc')
                ->leftJoin('kptype', 'sentence.type', 'kptype.id')
                ->leftJoin('content', 'sentence.content_id', 'content.id')
                ->leftJoin('title', 'content.title_id', 'title.id')
                ->leftJoin('standard', 'title.standard_id', 'standard.id')
                ->with(['tags'=>function($query) use($keyword){}])
                ->select('sentence.id', 'sentence', 'content', 'standard.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard')
                ->whereNotNull('sentence.sentence')
                ->where('sentence.import',1)
                ->whereIn('sentence.system_id', $array)
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
        $content = [];
        $titleId = [];
        $contentId = [];
        $isScout = true;
        try{
            $contents = Content::search($keyword)->get();

            foreach ($contents as $item){
                $contentId[] = $item->id;
                $titleId[] = $item->title_id;
                $content[$item->title_id] = $item->content;
            }

        }catch (\Exception $e) {
            $isScout = false;
        }



        if($isScout){
            $data = validateData(
                Sentence::orderBy('sentence.level', 'desc')
                    ->leftJoin('kptype', 'sentence.type', 'kptype.id')
//                ->leftJoin('content', 'sentence.content_id', 'content.id')
                    ->leftJoin('title', 'sentence.title_id', 'title.id')
                    ->leftJoin('standard', 'title.standard_id', 'standard.id')
                    ->with(['tags'=>function($query) use($keyword){}])
                    ->select('sentence.id', 'sentence', 'standard.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard','sentence.title_id')
                    ->whereNotNull('sentence.sentence')
                    ->whereIn('title_id',$titleId)
//                ->where('content.content', 'like', "%{$keyword}%")
                    ->where('sentence.import',1)
                    ->paginate($pageSize)
            );
            if($data['msg'] == 1){
                foreach ($data['data'] as $item){
                    $item->content =  isset($content[$item->title_id]) ? $content[$item->title_id] : '';
                }
            }
        }else{
            $data = validateData(
                Sentence::orderBy('sentence.level', 'desc')
                    ->leftJoin('kptype', 'sentence.type', 'kptype.id')
                    ->leftJoin('content', 'sentence.content_id', 'content.id')
                    ->leftJoin('title', 'content.title_id', 'title.id')
                    ->leftJoin('standard', 'title.standard_id', 'standard.id')
                    ->with(['tags'=>function($query) use($keyword){}])
                    ->select('sentence.id', 'sentence', 'content','standard.user', 'page_id', 'model_id', 'kptype.name as type', 'standard.name as standard','sentence.title_id')
                    ->whereNotNull('sentence.sentence')
                    ->where('content.content', 'like', "%{$keyword}%")
                    ->where('sentence.import',1)
                    ->paginate($pageSize)
            );
        }
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

    public function resultDelete(Request $request){
        $name = $request->input('name');
        $data = validateData(
            Export::where('name',$name)->delete()
        );
        return responseJson($data);
    }

    public function savePageResult(Request $request){
        return 1;
    }



    public function searchImage(Request $request){
//        $user = $request->input('user','张江腾');
        $user = $request->user;
        $keyword = '/content_';
        $data = Content::where('content', 'like', "%{$keyword}%")
            ->leftJoin('title', 'content.title_id', 'title.id')
            ->leftJoin('standard', 'title.standard_id', 'standard.id')
//            ->select('title.id','title as 标题','name as 规范','level as 层级','standard.user as 收集人')
            ->select('title.id','title as 章节','name as 规范','level as 层级','standard.user as 收集人')
            ->where('standard.user',$user)
            ->get();

        $width = [
            'A' => 10,
            'B' => 50,
            'C' => 15,
            'D' => 8,
            'E' => 15,

//            'I' => 10,
//            'J' => 30,
        ];
        $exports = [];
        foreach ($data as $k=>$item){
            $exports[$k][1] = $k+1;
            $exports[$k][2] = $item->规范;
            $exports[$k][3] = $item->章节;
            $exports[$k][4] = $item->层级;
            $exports[$k][5] = $item->收集人;
        }

        $excelName = "kp-图片补充({$user})";
        $row = ['序号', '规范', '标题', '层级', '收集人'];

        $count = count($row);


        Excel::export($excelName, $row, $exports, $width, $count);
    }

}

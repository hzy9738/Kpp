<?php

namespace App\Http\Controllers;

use App\Model\Sentence;
use App\Model\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function keyword(Request $request)
    {
        $keyword  = $request->input('keyword');
        $data =  Tag::where('tag','like',"%{$keyword}%")->get();
        return responseJson($data);
    }


    public function category(Request $request)
    {
        $keyword  = $request->input('keyword');
        $pageSize  = $request->input('pageSize',10);
        $array = self::keywordFormdata($keyword);
        $data = validateData(
            Tag::orderBy('tag.id','desc')
                ->leftJoin('sentence_tag','sentence_tag.tag_id','tag.id')
                ->leftJoin('sentence','sentence_tag.sentence_id','sentence.id')
                ->leftJoin('content','sentence.content_id','content.id')
                ->leftJoin('title','content.title_id','title.id')
                ->leftJoin('standard','title.standard_id','standard.id')
                ->leftJoin('kptype','standard.type_id','kptype.id')
                ->whereNotNull('sentence.sentence')
                ->whereIn('sentence.model_id',$array)
                ->select('tag.id','tag','sentence','content','sentence.user','page_id','model_id','kptype.name as type','standard.name as standard')
                ->paginate($pageSize)
        );
        return responseJson($data);
    }


    public static function keywordFormdata($keyword){
        $array = [];
        foreach ($keyword as $key => $item){
            if($key>=1){
                $array[$key] = $array[$key-1] .",".$item;
            }else{
                $array[0] = "{$item}";
            }
        }
        return $array;
    }
}

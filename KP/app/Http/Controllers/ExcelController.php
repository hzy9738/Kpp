<?php

namespace App\Http\Controllers;

use App\Excel;
use App\Model\Tag;
use Illuminate\Http\Request;



class ExcelController extends Controller
{
    public function excelExport(Request $request)
    {
        $keyword  = $request->input('keyword','');
        $keyword  = explode(',',$keyword);
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


        if(!$data['msg']){
            return false;
        }
        $exports = [];
        foreach ($data['data'] as $item){
            $exports[] = $item->tag;
        }

        $width = [
            'A' => 10,
            'B' => 10,
            'C' => 20,
            'D' => 30,
            'E' => 10,
            'F' => 10,
            'G' => 10,
//            'I' => 10,
//            'J' => 30,
        ];

        $excelName = 'tag';
        $row = ['序号', '姓名', '中心', '岗位'];

        $count = count($row);
        $excel = new Excel();

        Excel::export($excelName, $row, $exports, $width, $count);
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

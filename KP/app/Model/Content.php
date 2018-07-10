<?php

namespace App\Model;



class Content extends Model
{
    protected $table = 'content';


    public static function saveContent($request){
        $update = [
            'title_id' => $request->input('title'),
        ];
        $data = [
            'content' => $request->input('content'),
            'category_id' => $request->input('category',1),
            'title_id' => $request->input('title'),
        ];
        $titleId =   $request->input('title');
        $sentences = $request->input('sentences',[]);

        $result = validateData(
            $content = self::updateOrCreate($update,$data),
            Sentence::saveSentences($sentences,$titleId,$content->id)
//            $createtime = Tag::saveTags($tags),
//            TitleTag::saveTitleTags($title,$createtime)
        );
        return $result;
    }
}

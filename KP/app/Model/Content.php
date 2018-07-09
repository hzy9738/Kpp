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
            'user_id' => $request->input('user',1),
        ];
        $tags = $request->input('tags',[]);
        $title = $request->input('title',0);
        $result = validateData(
            self::updateOrCreate($update,$data),
            $createtime = Tag::saveTags($tags),
            TitleTag::saveTitleTags($title,$createtime)
        );
        return $result;
    }
}

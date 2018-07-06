<?php

namespace App\Model;



class Content extends Model
{
    protected $table = 'content';


    public static function saveContent($request){
        $data = [
            'content' => $request->input('content'),
            'category_id' => $request->input('category'),
            'title_id' => $request->input('title'),
            'user_id' => $request->input('user',1),
        ];
        $result = validateData(
            self::create($data)
        );
        return $result;
    }
}

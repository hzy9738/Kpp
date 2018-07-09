<?php

namespace App\Model;


use Illuminate\Support\Facades\Log;

class Tag extends Model
{
    protected $table = 'tag';


    public static function saveTags($tags){
        $time = time();
        $data = [];
        foreach ($tags as $key => $tag){
            $data[$key]['tag'] = $tag;
            $data[$key]['createtime'] = $time;
        }

        try{
            self::insert($data);
        }catch (Exception $e) {
            self::where('createtime',$time)->delete();
        }
        return $time;
    }


    public static function getId($createtime){
       return  $data = self::where('createtime',$createtime)->pluck('id');
    }
}

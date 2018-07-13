<?php

namespace App\Model;


use Illuminate\Support\Facades\Log;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    protected $table = 'tag';

//    use Searchable;

//    public function searchableAs()
//    {
//        return 'tag';
//    }
//
//
//
//    public function toSearchableArray()
//    {
//        $array = $this->toArray();
//
//        // Customize array...
//
//        return $array;
//    }











    public static function saveTags($time,$tags,$sentenceIds){
        $data = [];
            foreach ($tags as $key => $tagArray){
                foreach ($tagArray as $tag){
                    $data['tag'] = $tag;
                    $data['createtime'] = $time;
                    $tag = self::updateOrCreate(['tag'=>$tag],$data);
                    SentenceTag::saveTitleSentences($tag->id,$sentenceIds[$key]);
                }
            }

        return 1;
    }


    public static function getId($createtime){
       return  $data = self::where('createtime',$createtime)->pluck('id');
    }
}

<?php

namespace App\Model;


class Sentence extends Model
{

    protected $table = 'sentence';

    public static function saveSentences($sentences, $titleId, $content_id)
    {
        $time = time();
        $data = [];
        $tags = [];
        foreach ($sentences as $key => $sentence) {
            $data[$key]['sentence'] = $sentence['sentence'];
            $data[$key]['page_id'] = implode(',', $sentence['knowledge']);
            $data[$key]['model_id'] = implode(',', $sentence['model']);
            $data[$key]['content_id'] = $content_id;
            $data[$key]['title_id'] = $titleId;
            $data[$key]['user'] = $sentence['user'];
            $data[$key]['createtime'] = $time;
            $tags[] = $sentence['tags'];
        }
        try {
            self::where('content_id', $content_id)->delete();
            if (self::insert($data)) {
                $sentenceIds = self::where('content_id', $content_id)->orderBy('id', 'asc')->pluck('id');
                if (count($sentenceIds) == count($tags)) {
                    Tag::saveTags($time, $tags, $sentenceIds);
                }
            }

        } catch (Exception $e) {
            self::where('createtime', $time)->delete();
        }
        return $time;
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'sentence_tag', 'sentence_id', 'tag_id');
    }


    public static function getCategory()
    {
        $pages = self::orderBy('id')->pluck('page_id');
        $model = self::orderBy('id')->pluck('model_id');
        $categroy = [];
        foreach ($pages as $item){
            $array = explode(',',$item);
            $categroy = array_merge($categroy,$array);
        }
        foreach ($model as $item){
            $array = explode(',',$item);
            $categroy = array_merge($categroy,$array);
        }
        $categroy = array_unique($categroy);
        return $categroy;
    }
}

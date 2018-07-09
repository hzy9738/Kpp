<?php

namespace App\Model;


use Illuminate\Support\Facades\Log;

class TitleTag extends Model
{
    protected $table = 'title_tag';

    protected $hidden = 'createtime';

    public static function saveTitleTags($title, $createtime)
    {
        $tagIds = Tag::getid($createtime);

        $data = [];
        foreach ($tagIds as $key => $id) {
            $data[$key]['title_id'] = $title;
            $data[$key]['tag_id'] = $id;
        }
        return validateData(
            self::where('title_id',$title)->delete(),
            self::insert($data)
        );
    }

}

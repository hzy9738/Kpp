<?php

namespace App\Model;


use Laravel\Scout\Searchable;

class Content extends Model
{
    use Searchable;

    public function searchableAs()
    {
        return 'content';
    }

    public function toSearchableArray()
    {
        return [
            'id'=> $this->id,
            'content' => $this->content,
            'title_id' => $this->title_id,
//            'content' => $this->content()->content
        ];
    }




    protected $table = 'content';


    public static function saveContent($request){
        $update = [
            'title_id' => $request->input('title'),
        ];
        $data = [
            'content' => $request->input('content'),
//            'category_id' => $request->input('category',1),
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

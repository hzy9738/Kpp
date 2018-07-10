<?php

namespace App\Model;


use Illuminate\Support\Facades\Log;

class SentenceTag extends Model
{
    protected $table = 'sentence_tag';

    protected $hidden = 'createtime';

//Exception
    public static function saveTitleSentences($tagId, $sentenceId)
    {
        $data = [
            'tag_id' => $tagId,
            'sentence_id' => $sentenceId,
        ];
        try {
            return self::create($data);

        } catch (Exception $e) {
            return false;
        }


    }

}

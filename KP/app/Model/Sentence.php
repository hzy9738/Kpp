<?php

namespace App\Model;


use Illuminate\Support\Facades\DB;

class Sentence extends Model
{

    protected $table = 'sentence';

    public static function saveSentences($sentences, $titleId, $content_id)
    {
        $time = time();
        $data = [];
        $tags = [];
        foreach ($sentences as $key => $sentence) {
            $data[$key]['sentence'] = isset($sentence['sentence']) ? $sentence['sentence'] : '';
            $data[$key]['page_id'] = implode(',', $sentence['knowledge']);
            $data[$key]['model_id'] = implode(',', $sentence['model']);
            $data[$key]['content_id'] = $content_id;
            $data[$key]['title_id'] = $titleId;
            $data[$key]['import'] = isset($sentence['import']) ? (  $sentence['import'] ? 1 : 0  ): 0;
            $data[$key]['level'] = count($sentence['model']);
            $data[$key]['createtime'] = $time;
            $data[$key]['type'] = isset( $sentence['type']) ?  $sentence['type'] : 0;
            $tags[] = isset($sentence['tags']) ? $sentence['tags'] : [];
        }
        try {
            self::where('content_id', $content_id)->delete();
            if (self::insert($data)) {
                $sentenceIds = self::where('content_id', $content_id)->orderBy('id', 'asc')->pluck('id');
                if (count($sentenceIds) == count($tags) && count($tags) != 0) {
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



    public function updateBatch($multipleData = [])
    {
        try {
            if (empty($multipleData)) {
                throw new \Exception("数据不能为空");
            }
            $tableName = DB::getTablePrefix() . $this->getTable(); // 表名
            $firstRow  = current($multipleData);

            $updateColumn = array_keys($firstRow);
            // 默认以id为条件更新，如果没有ID则以第一个字段为条件
            $referenceColumn = isset($firstRow['id']) ? 'id' : current($updateColumn);
            unset($updateColumn[0]);
            // 拼接sql语句
            $updateSql = "UPDATE " . $tableName . " SET ";
            $sets      = [];
            $bindings  = [];
            foreach ($updateColumn as $uColumn) {
                $setSql = "`" . $uColumn . "` = CASE ";
                foreach ($multipleData as $data) {
                    $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN ? ";
                    $bindings[] = $data[$referenceColumn];
                    $bindings[] = $data[$uColumn];
                }
                $setSql .= "ELSE `" . $uColumn . "` END ";
                $sets[] = $setSql;
            }
            $updateSql .= implode(', ', $sets);
            $whereIn   = collect($multipleData)->pluck($referenceColumn)->values()->all();
            $bindings  = array_merge($bindings, $whereIn);
            $whereIn   = rtrim(str_repeat('?,', count($whereIn)), ',');
            $updateSql = rtrim($updateSql, ", ") . " WHERE `" . $referenceColumn . "` IN (" . $whereIn . ")";
            // 传入预处理sql语句和对应绑定数据
            return DB::update($updateSql, $bindings);
        } catch (\Exception $e) {
            return false;
        }
    }
}

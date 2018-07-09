<?php

namespace App\Model;


use App\Http\Validate\TitleValidate;
use Illuminate\Support\Facades\Log;


class Title extends Model
{
    protected $table = 'title';

    public static function createTitle($request){
        $data = [
            'level' => 0,
            'pid' => 0,
            'standard_id' => $request->input('standard'),
            'title' => $request->input('title')
        ];
        return validateData(
            self::create($data)
        );
    }

    public static function lists($request){
        $id = $request->input('id');
        if(isset($id)){
            $data = validateData(
                self::orderBy('id')->where('standard_id',$id)->where('pid',0)->with('children')->get()
            );
        }else{
            $data = validateData(
                self::orderBy('id')->where('pid',0)->with('children')->get()
            );
        }
        return $data;
    }


    public static  function addTitle($request)
    {
        $data = [
            'title' => $request->input('title'),
            'pid' => $request->input('id'),
            'level' => $request->input('level'),
            'standard_id' => $request->input('standard'),
        ];
        $data = validateData(
            self::create($data)
        );
        return $data;
    }

    public function children()
    {
        return $this->hasMany(Title::class, 'pid', 'id')
            ->with('children');
    }

    public function detail()
    {
        return $this->belongsTo(Content::class,'id','title_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'title_tag','title_id','tag_id');
    }



    public static function deleteTitle($title){
        $ids = [];
        $ids[] = $title->id;
        $data = $title->load('children');
        self::_getIds($data,$ids);
        $result = validateData(
            Title::whereIn('id',$ids)->delete()
        );
        return $result;
    }

    public static function _getIds($data,&$ids){
        foreach ($data->children as $item){
            $ids[] = $item->id;
            self::_getIds($item,$ids);
        }
        return $ids;
    }
}


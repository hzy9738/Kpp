<?php

namespace App\Model;


use App\Http\Validate\TitleValidate;
use Illuminate\Support\Facades\Log;


class Title extends Model
{
    protected $table = 'title';

    public static function lists(){
        $data = validateData(
            self::orderBy('id')->where('pid',0)->with('children')->get()
        );
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
        return $this->belongsToMany(Tag::class,'title_tag','tag_id','title_id');
    }
}


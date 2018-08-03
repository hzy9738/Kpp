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

    public static function updateTitle($request){
         $title = self::find($request->input('id',0));
         $title->title = $request->input('title','');
        return validateData(
            $title->save()
        );
    }



    public static function lists($id){
        if($id !== -1){
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


    public static function pdf($id){
        if($id !== -1){
            $data = validateData(
                self::orderBy('id')->where('standard_id',$id)->where('pid',0)->with('child.detail')->get()
            );
        }else{
            $data = validateData(
                self::orderBy('id')->where('pid',0)->with('children')->get()
            );
        }
        return $data;
    }

    public function child()
    {
        return $this->hasMany(Title::class, 'pid', 'id')
            ->with('child','detail');
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



    public function sentences()
    {
        return $this->hasMany(Sentence::class,'title_id','id');
    }



    public static function deleteTitle($id){
        $title = self::find($id);
        $ids = [];
        $ids[] = $id;
        $data = $title->load('children');
        self::_getIds($data,$ids);
        $result = validateData(
            Title::whereIn('id',$ids)->delete(),
            Sentence::whereIn('title_id',$ids)->delete()
        );
        return $result;
    }

    public static function deleteTitlesByStandard($standardId){
        $ids = Title::where('standard_id',$standardId)->pluck('id');
        $result = validateData(
            Title::where('standard_id',$standardId)->delete(),
            Sentence::whereIn('title_id',$ids)->delete()
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

    public static  function getSentences($title){

        $data = $title->load('sentences.tags');

        return validateData($data);
    }


}


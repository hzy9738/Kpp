<?php

namespace App\Model;


use Illuminate\Support\Facades\Log;

class Standard extends Model
{
    protected $table = 'standard';

    public function types()
    {
        return $this->belongsTo(Kptype::class, 'type_id', 'id');
    }

    public static function addStandard($request)
    {
        $data = [
            'name' => $request->input('name'),
            'user' => $request->input('user',''),
        ];
        $data = validateData(
            self::create($data)
        );
        return $data;
    }

    public static function updateStandard($request)
    {
        $data = [
            'name' => $request->input('name'),
            'user' => $request->input('user'),
        ];
        $model =  self::find(  $request->input('id') );

        $data = validateData(
            $model->update($data)
        );

        return $data;
    }

    public static function deleteStandard($id){
       self::where('id',$id)->delete();
       Title::deleteTitlesByStandard($id);
    }
}

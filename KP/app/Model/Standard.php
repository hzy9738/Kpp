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
            'type_id' => $request->input('type'),
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
            'type_id' => $request->input('type'),
        ];
        $model =  self::find(  $request->input('id') );

        $data = validateData(
            $model->update($data)
        );

        return $data;
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: HZY
 * Date: 2018/7/4
 * Time: 15:24
 */

namespace App\Http\Validate;


use App\Model\Sentence;
use Illuminate\Support\Facades\Validator;

class CategoryValidate
{
    public static function validate($request)
    {
        //验证
        $validator = Validator::make($request->all(), [

            'name' => 'required|max:10',
        ], [
            'required' => ':attribute为必填',
        ], [
            'name' => '子标准名称',
        ]);

        if ($validator->fails()) {
            return [
                'msg' => config('code.error'),
                'data' => $validator->errors()->first()
            ];
        }

        return [
            'msg' => config('code.success'),
            'data' => 'success'
        ];


    }

    public static function validateDelete($id){
        $ids = Sentence::getCategory();
        if (in_array($id,$ids)) {
            return [
                'msg' => config('code.error'),
                'data' => '',
                'message'=> '存在相关联的简述，无法删除'
            ];
        }

        return [
            'msg' => config('code.success'),
            'data' => 'success'
        ];
    }

}
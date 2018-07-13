<?php
/**
 * Created by PhpStorm.
 * User: HZY
 * Date: 2018/7/4
 * Time: 15:24
 */

namespace App\Http\Validate;


use App\Model\Title;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StandardValidate
{
    public static function validate($request)
    {
        //验证
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:standard|max:30',
            'type' => 'required'
        ], [
            'required' => ':attribute为必填',
            'unique'=>':attribute已存在,不可重复'
        ], [
            'name' => '知识点来源',
            'type' => '知识类型',
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

    public static function update($request)
    {
        //验证
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:30',
                 Rule::unique('standard')->ignore($request->id),
            ],
            'type' => 'required'
        ], [
            'required' => ':attribute为必填',
            'unique'=>':attribute已存在,不可重复'
        ], [
            'name' => '知识点来源',
            'type' => '知识类型',
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
        $count = Title::where('standard_id',$id)->count();
        if ($count > 0) {
            return [
                'msg' => config('code.error'),
                'data' => '',
                'message'=> '存在已录入的内容，无法删除'
            ];
        }

        return [
            'msg' => config('code.success'),
            'data' => 'success'
        ];
    }

}
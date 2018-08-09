<?php
/**
 * Created by PhpStorm.
 * User: HZY
 * Date: 2018/7/4
 * Time: 15:24
 */

namespace App\Http\Validate;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TitleValidate
{
    public static function validate($request)
    {
        //验证
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'level' => 'required',
            'standard' => 'required',
        ], [
            'required' => ':attribute为必填',
            'unique'=>':attribute已存在,不可重复'
        ], [
            'name' => '知识点来源',
            'level' => '上级目录',
            'standard' => '所属类型',
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
            'title' => [
                'required',
                'max:100',
            ],
            'id' => 'required',
        ], [
            'required' => ':attribute为必填',
            'unique'=>':attribute已存在,不可重复'
        ], [
            'name' => '章节名称',
            'id' =>   '章节ID',
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

}
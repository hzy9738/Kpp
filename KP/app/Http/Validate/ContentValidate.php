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

class ContentValidate
{
    public static function validate($request)
    {
        //验证
        $validator = Validator::make($request->all(), [
            'content' => 'required|unique:content|max:5000',
//            'category_id' => 'required',
            'title' => 'required',
            'tags'=>'required'
        ], [
            'required' => ':attribute为必填',
            'unique'=>':attribute已存在,不可重复'
        ], [
            'content' => '章节内容',
            'tags' => '标签',
            'title' => '章节',
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
            'content' => [
                'required',
                'max:5000',
                 Rule::unique('content')->ignore($request->id),
            ],
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

}
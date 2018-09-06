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
            'content' => [
//                'required',
                'max:1000000',
            ],
            'sentences.*.sentence' => 'max:250',
//            'sentences.*.knowledge' => 'required',
//            'sentences.*.model' => 'required',
//            'sentences.*.type' => 'required',
//            'sentences.*.tags' => 'required',
            'title' => 'required',
        ], [
            'required' => ':attribute为必填',
            'unique'=>':attribute已存在,不可重复',
            'max'=>':attribute最多:max个字',
        ], [
            'content' => '章节内容',
            'tags' => '标签',
            'title' => '章节',
            'sentences.*.sentence' => '简述',
            'sentences.*.knowledge' => '知识点分类',
            'sentences.*.model' => '标准分类',
            'sentences.*.system' => '系统分类',
            'sentences.*.type' => '类型',
            'sentences.*.tags' => '标签',
        ]);

        if ($validator->fails()) {
            return [
                'msg' => config('code.error'),
                'data' => $validator->errors()->first(),
                'message'=>$validator->errors()->first(),
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
//                'required',
                'max:1000000',
                 Rule::unique('content')->ignore($request->id),
            ],
            'level' => 'required',
            'standard' => 'required',
        ], [
            'required' => ':attribute为必填',
            'unique'=>':attribute已存在,不可重复',
            'max'=>':attribute最多:max个字',
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
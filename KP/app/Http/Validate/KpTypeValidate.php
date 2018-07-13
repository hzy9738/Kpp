<?php
/**
 * Created by PhpStorm.
 * User: HZY
 * Date: 2018/7/4
 * Time: 15:24
 */

namespace App\Http\Validate;




use App\Model\Standard;

class KpTypeValidate
{

    public static function validateDelete($id){
        $count = Standard::where('type_id',$id)->count();
        if ($count === 0) {
            return [
                'msg' => config('code.error'),
                'data' => '',
                'message'=> '存在相关联的知识点来源，无法删除'
            ];
        }

        return [
            'msg' => config('code.success'),
            'data' => 'success'
        ];
    }

}
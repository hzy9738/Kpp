<?php
/**
 * Created by PhpStorm.
 * User: HZY
 * Date: 2018/7/11
 * Time: 18:06
 */

namespace App;


class Excel
{

//导出excel
    public static function  export($name,$row,$data,$width=[],$count,$ecxelX=[],$managerCount=0,$frame=[]){
        \Maatwebsite\Excel\Facades\Excel::create($name, function($excel) use ($data,$row,$width,$count){
            $excel->sheet('Sheetname', function($sheet) use($data,$row,$width,$count) {
                $sheet->fromArray($data);
                $sheet->row(1,$row);
                $sheet->setWidth($width);
            });

        })->export('xlsx');
    }
}
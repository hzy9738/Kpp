<?php

namespace App\Http\Controllers;

use App\Model\Export;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function savePage(Request $request)
    {

        $requests = $request->all();
        $createtime = time();

        Export::where('createtime','<=',$createtime-86400)->delete();
         $data = validateData(
             Export::insert($requests)
         );
        return responseJson($data);
    }
}

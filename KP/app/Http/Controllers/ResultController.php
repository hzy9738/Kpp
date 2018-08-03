<?php

namespace App\Http\Controllers;

use App\Model\Export;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function savePage(Request $request)
    {

        $requests = $request->all();
         $data = validateData(
             Export::insert($requests)
         );
        return responseJson($data);
    }
}

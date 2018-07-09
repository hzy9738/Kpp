<?php

namespace App\Http\Controllers;

use App\Http\Validate\StandardValidate;

use App\Model\Standard;

use Illuminate\Http\Request;

class StandardController extends Controller
{
    public function lists()
    {
        $data = validateData(
            Standard::orderBy('id', 'desc')->with('types')->get()
        );
        return responseJson($data);
    }

    public function getLists()
    {
        $data = validateData(
            Standard::orderBy('id', 'desc')->with('types')->paginate(10)
        );
        return responseJson($data);
    }

    public function addStandard(Request $request)
    {
        $result = StandardValidate::validate($request);
        if ($result['msg']) {
            $result = Standard::addStandard($request);
        }
        return responseJson($result);
    }

    public function updateStandard(Request $request)
    {
        $result = StandardValidate::update($request);
        if ($result['msg']) {
            $result = Standard::updateStandard($request);
        }
        return responseJson($result);
    }


    public function deleteStandard(Standard $standard)
    {
        $data = validateData(
            $standard->delete()
        );
        return responseJson($data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Model\Kptype;
use Illuminate\Http\Request;

class KptypeController extends Controller
{
    public function lists()
    {
        $data = validateData(
            Kptype::orderBy('id')->get()
        );
        return responseJson($data);
    }

    public function getLists()
    {
        $data = validateData(
            Kptype::orderBy('id')->paginate(10)
        );
        return responseJson($data);
    }
}

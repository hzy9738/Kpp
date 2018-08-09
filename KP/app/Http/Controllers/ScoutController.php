<?php

namespace App\Http\Controllers;

use App\Model\Content;
use App\Model\Title;
use Illuminate\Http\Request;

class ScoutController extends Controller
{
    public function getScout(){
        $data = Content::search('528')->where('id',528)->first();
        return $data;
    }
}

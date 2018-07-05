<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Validate\CategoryValidate;
use App\Model\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function lists()
    {
        $data = Category::lists();
        return responseJson($data);
    }


    public function models()
    {
        $data = Category::models();
        return responseJson($data);
    }

    public function pages()
    {
        $data = Category::pages();
        return responseJson($data);
    }

    public function addModel(Request $request)
    {
        $result = CategoryValidate::validate($request);
        if($result['msg']){
            $result = Category::addModel($request);
        }
        return responseJson($result);
    }

    public function addPage(Request $request)
    {
        $result = CategoryValidate::validate($request);
        if($result['msg']){
            $result = Category::addPage($request);
        }
        return responseJson($result);
    }

    public function deleteCategory(Category $category)
    {
        $result = Category::deleteCategory($category);
        return responseJson($result);
    }
}

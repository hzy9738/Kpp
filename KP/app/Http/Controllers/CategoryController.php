<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Validate\CategoryValidate;
use App\Model\Category;
use App\Model\Sentence;
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
        if($result['msg'] === config('code.success')){
            $result = Category::addModel($request);
        }
        return responseJson($result);
    }

    public function addPage(Request $request)
    {
        $result = CategoryValidate::validate($request);
        if($result['msg'] === config('code.success')){
            $result = Category::addPage($request);
        }
        return responseJson($result);
    }

    public function deleteCategory(Category $category)
    {
        $result = CategoryValidate::validateDelete($category->id);
        if($result['msg'] === config('code.success')){
            $result = Category::deleteCategory($category);
        }
        return responseJson($result);
    }
}

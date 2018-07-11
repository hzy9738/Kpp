<?php

namespace App\Model;

use Laravel\Scout\Searchable;


class Category extends Model
{

    use Searchable;

    protected $table = 'category';

    public $timestamps = false;

    // scout  start


    public function searchableAs()
    {
        return 'category_index';
    }



    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }








    // end













    public static function lists()
    {
        $data = validateData(
            self::orderBy('id')
                ->select('id', 'pid', 'type', "name as title", 'status')
                ->pluck('title','id')
        );
        return $data;
    }


    public static function models()
    {
        $data = validateData(
            self::orderBy('id')
                ->with('modelChild')
                ->where('type', 'default')
                ->where('status', 'normal')
                ->where('pid', '0')
                ->select('id', 'pid', 'type', "name as title", 'status')
                ->get()
        );
        return $data;
    }

    public static function pages()
    {
        $data = validateData(
            self::orderBy('id')
                ->with('pageChild')
                ->where('type', 'page')
                ->where('status', 'normal')
                ->where('pid', '0')
                ->select('id', 'pid', 'type', "name as title", 'status')
                ->get()
        );
        return $data;
    }

    public function modelChild()
    {
        return $this->hasMany(Category::class, 'pid', 'id')
            ->where('status', 'normal')
            ->where('type', 'default')
            ->with('modelChild')
            ->select('id', 'pid', 'type', 'name as title', 'status');
    }

    public function pageChild()
    {
        return $this->hasMany(Category::class, 'pid', 'id')
            ->with('pageChild')
            ->where('status', 'normal')
            ->where('type', 'page')
            ->select('id', 'pid', 'type', 'name as title', 'status');
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'pid', 'id')
            ->where('status', 'normal')
            ->with('child')
            ->select('id', 'pid', 'type', 'name as title', 'status');
    }

    public static function addModel($request)
    {
        $data = [
            'pid' => $request->input('id'),
            'name' => $request->input('name') ,
            'type' => $request->input('type'),
            'status' => 'normal',
            'createtime' => time(),
            'updatetime' =>  time(),
        ];
        $data = validateData(
            self::create($data)
        );
        return $data;
    }

    public static function addPage($request)
    {
        $data = [
            'pid' => $request->input('id'),
            'name' => $request->input('name') ,
            'type' => $request->input('type'),
            'status' => 'normal',
            'createtime' => time(),
            'updatetime' =>  time(),
        ];
        $data = validateData(
            self::create($data)
        );
        return $data;
    }

    public static function deleteCategory($category){
        $ids = [];
        $ids[] = $category->id;
        $data = $category->load('child');
        self::_getIds($data,$ids);
        $result = validateData(
            Category::whereIn('id',$ids)->delete()
        );
        return $result;
    }

    public static function _getIds($data,&$ids){
        foreach ($data->child as $item){
            $ids[] = $item->id;
            self::_getIds($item,$ids);
        }
        return $ids;
    }
}

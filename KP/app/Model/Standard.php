<?php

namespace App\Model;


use Illuminate\Support\Facades\Log;

class Standard extends Model
{
    protected $table = 'standard';

    public function types()
    {
        return $this->belongsTo(Kptype::class, 'type_id', 'id');
    }

    public static function addStandard($request)
    {
        $data = [
            'name' => $request->input('name'),
            'user' => $request->input('user',''),
        ];
        $data = validateData(
            self::create($data)
        );
        return $data;
    }

    public static function updateStandard($request)
    {
        $data = [
            'name' => $request->input('name'),
            'user' => $request->input('user'),
        ];
        $model =  self::find(  $request->input('id') );

        $data = validateData(
            $model->update($data)
        );

        return $data;
    }

    public static function deleteStandard($id){
       self::where('id',$id)->delete();
       Title::deleteTitlesByStandard($id);
    }

    public function titles(){
        return $this->hasMany(Title::class);
    }


    public static function watchStandard($id){
          $data = self::where('id',$id)->with('titles.detail')->get();
           $html= "";
          self::_formStyle($data,$html);
          return $html;
    }

    public static function _formStyle(&$data,&$html=''){
            foreach ($data as $item){
                $html .= "<h1 style='align-content: center'>".$item->name."</h1>";
                self::_formData($item->titles,$html);
            }
    }
    public static function _formData(&$data,&$html=''){
        foreach ($data as $item){

            $html .= "<h4 style='align-content: left;color: black'><strong>".$item->title."</strong></h4>";
            if(isset($item->detail->content)){
                $html .= "<p>".$item->detail->content."</p>";
            }
            if(isset($item->titles)){
                self::_formData($item->titles,$html);
            }
        }

    }
}

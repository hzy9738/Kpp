<?php

namespace App\Http\Controllers;

use Fukuball\Jieba\Finalseg;
use Illuminate\Http\Request;

use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Posseg;
use Fukuball\Jieba\JiebaAnalyse;

class WordController extends Controller
{
    private $jieba = null;
    private $finalseg  = null;


    public function __construct()
    {
        //这边要给内存，不然会炸
        ini_set('memory_limit', '1024M');
        //初始化
        $this->jieba = new Jieba();
        $this->finalseg = new Finalseg();

        $this->jieba->init();
        $this->finalseg->init();
        JiebaAnalyse::init();
    }


    /**
     * @Name 分词
     * @Description 分词接口
     * @Param content:  章节内容
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     *  data{
     *     "code":1,
     *     "data":{
     *          ...
     *      },
     *     "message":"success"
     * }
     */
    public function getTags(Request $request)
    {


        $content = $request->input('content','');

        $tags = JiebaAnalyse::extractTags($content, 10);

        foreach ($tags as $key => $tag){
            $data[] = $key;
        }
        $res = new \stdClass();
        $res->code = 1;
        $res->data = $data;
        return response()->json($res);
    }
}

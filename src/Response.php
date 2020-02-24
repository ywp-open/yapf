<?php
namespace Yapf;

class Response
{
    public function __construct()
    {
    }

    /**
     * @param $v string|array|object
     */
    public function json(int $code,$v)
    {
        $array = array(
            'code'=>$code,
            'data'=>$v
        );
        $ret = json_encode($array,JSON_UNESCAPED_UNICODE);
        if(false===$ret){
            throw new \Exception('json fail');
        }
        echo $ret;
        exit;
    }
}

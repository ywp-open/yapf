<?php
namespace Yapf;

class Response
{
    public function __construct(){}

    /**
     * @param $v string|array|object
     */
    public function json(int $code, $v)
    {
        header('content-type:application/json;charset=utf-8');
        $array = array(
            'code' => $code,
            'data' => $v
        );
        $ret = json_encode($array, JSON_UNESCAPED_UNICODE);
        if (false === $ret) {
            throw new \Exception('json fail');
        }
        echo $ret;
        exit;
    }

    public function render(string $template,array $data=array())
    {
        header('content-type:text/html;charset=utf-8');
        if($data){
            extract($data);
        }
        ob_start();
        require 'template/' . $template . '.html';
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
        exit;
    }
}

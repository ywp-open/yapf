<?php
namespace Yapf;

class Request
{
    private static ?Request $instance = null;

    private function __construct(){}

    public static function getInstance()
    {
        if(is_null(self::$instance)){
            return new self;
        }
        return self::$instance;
    }

    public function getHeaderEntry(string $key):?string
    {
        foreach($_SERVER as $k=>$v){
            if(substr($k,0,5)=='HTTP_'){
                if('HTTP_'.strtoupper($key)==$k){
                    return $v;
                }
            }
        }
        return null;
    }

    public function getHeaderAll():array
    {
        $arr = array();
        foreach($_SERVER as $key=>$v){
            if(substr($key,0,5)=='HTTP_'){
                $arr[$key] = $v;
            }
        }
        return $arr;
    }

    public function getServerVar(string $key):?string
    {
        return $_SERVER[strtoupper($key)];
    }

    public function requestMethod():string
    {
        return $this->getServerVar('request_method');
    }

    public function getQStrInt(string $key,int $defaults=0):int
    {
        if(array_key_exists($key,$_GET)){
            return intval($_GET[$key]);
        }
        else{
            return $defaults;
        }
    }

    public function getQStr(string $key,string $defaults=''):string
    {
        if(array_key_exists($key,$_GET)){
            return $_GET[$key];
        }
        else{
            return $defaults;
        }
    }

    public function getPost(string $key,string $default=''):string
    {
        if(array_key_exists($key,$_POST)){
            return $_POST[$key];
        }
        else{
            return $default;
        }
    }

    public function getPostInt(string $key,int $default=0):int
    {
        if(array_key_exists($key,$_POST)){
            return intval($_POST[$key]);
        }
        else{
            return $default;
        }
    }

    public function getPostObject(string $key):?object
    {
        if(array_key_exists($key,$_POST)){
            return (object)$_POST[$key];
        }
        else{
            return null;
        }
    }

    public function bodyjson():?object
    {
        $body = file_get_contents('php://input');
        return $body?json_decode($body):null;
    }
}

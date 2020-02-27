<?php
namespace Yapf;

class Route{
    private static array $array = array();
    private string $uri;
    private array $controller;
    private static ?Route $instance = null;

    private function __construct(){}

    public static function getInstance():Route{
        if(!self::$instance){
            self::$instance  = new self();
        }
        return self::$instance;
    }

    public static function add(string $key,array $obj){
        if(array_key_exists($key,self::$array)){
            throw new \Exception('has duplicate key');
        }
        else{
            self::$array[$key] = $obj;
        }
    }

    public function getAllEntry():array{
        return self::$array;
    }

    public function findEntry(string $uri):array{
        $isfind = array_key_exists($uri,self::$array);
        if(!$isfind){
            throw new \Exception('not has uri');
        }
        $this->uri = $uri;
        $this->controller = self::$array[$uri];
        return $this->controller;
    }

    public function getUri():string {
        return $this->uri;
    }

    public function getController():array {
        return $this->controller;
    }
}

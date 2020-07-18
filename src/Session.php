<?php
namespace Yapf;

class Session{
    public function __construct(){
        //session_start();
      if(ini_get('session.auto_start')!='1'){
        throw new \Exception('needed setting `session.auto_start=1` in php.ini');
      }
    }

    public function __get($name):?string{
        if(!array_key_exists($name,$_SESSION)){
            return null;
        }
        return $_SESSION[$name];
    }

    public function __set($name, $value){
        if(array_key_exists($name,$_SESSION)){
            throw new \Exception('session key has existed');
        }
        $_SESSION[$name] = $value;
    }

    public function __call($name, $arguments){
        switch($name){
            case 'get':
                return $this->{$arguments[0]};
                break;
            case 'set':
                $this->{$arguments[0]} = $arguments[1];
                break;
        }
    }

    public function get(string $name):?string{
        return $this->$name;
    }

    public function set(string $name,string $value){
        $this->$name = $value;
    }
}

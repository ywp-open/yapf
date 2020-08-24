<?php
namespace Yapf;

class Session
{
    private static int $_is_start = 0;
    private static ?Session $_self = null;

    private function __construct(){}

    public static function getInstance():Session
    {
        if(self::$_is_start==0){
            session_start();
            self::$_is_start = 1;
        }
        if(is_null(self::$_self)){
            self::$_self = new self();
        }
        return self::$_self;
    }

    public function __get($name): ?string
    {
        if (!array_key_exists($name, $_SESSION)) {
            return null;
        }
        return $_SESSION[$name];
    }

    public function __set($name, $value)
    {
        if (array_key_exists($name, $_SESSION)) {
            throw new \Exception('session key has existed');
        }
        $_SESSION[$name] = $value;
    }

    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'get':
                return $this->{$arguments[0]};
                break;
            case 'set':
                $this->{$arguments[0]} = $arguments[1];
                break;
        }
    }

    public function get(string $name): ?string
    {
        return $this->$name;
    }

    public function set(string $name, string $value)
    {
        $this->$name = $value;
    }
}

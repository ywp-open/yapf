<?php

namespace Yapf;

class Route
{
    private static array $_routes = array();
    private string $_uri;
    private array $_controller;
    private static ?Route $_instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): Route
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param array|string $obj
     */
    public static function add(string $key, $obj)
    {
        $hash = hash('crc32b',$key);
        if (array_key_exists($hash, self::$_routes)) {
            throw new \Exception('has duplicate key');
        }
        else {
            self::$_routes[$hash] = $obj;
        }
    }

    public function getAllEntry(): array
    {
        return self::$_routes;
    }

    public function findEntry(string $uri): array
    {
        $this->_uri = $uri;

        $hash = hash('crc32b',$uri);
        $isfind = array_key_exists($hash, self::$_routes);
        if(!$isfind){
            $uris = explode('/',$uri);
            array_pop($uris);
            $uri_str = implode('/',$uris);
            $hash = hash('crc32b',$uri_str);
            $isfind = array_key_exists($hash,self::$_routes);
            if(!$isfind){
                throw new \Exception('not has uri');
            }
        }

        $contrl = self::$_routes[$hash];
        if(!is_array($contrl)){
            $uris = explode('/',$uri);
            $action = strtolower($uris[count($uris)-1]);
            $this->_controller = [$contrl,$action];
        }
        else{
            $this->_controller = self::$_routes[$hash];
        }

        return $this->_controller;
    }

    public function getUri(): string
    {
        return $this->_uri;
    }

    public function getController(): array
    {
        return $this->_controller;
    }
}

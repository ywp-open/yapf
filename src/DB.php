<?php
namespace Yapf;
use Medoo\Medoo;

class DB extends Medoo{
    private static ?Medoo $dao = null;

    private function __construct(array $options){
        parent::__construct($options);
    }

    public static function init(array $options){
        self::$dao = new self($options);
    }

    public static function dao(){
        return self::$dao;
    }

    public static function findAll(string $sql,array $where=array()):array{
        return self::$dao->query($sql,$where)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findFirst(string $sql,array $where=array()):?array{
        $data = self::$dao->query($sql,$where)->fetch(\PDO::FETCH_ASSOC);
        return is_bool($data)?null:$data;
    }
}

<?php
namespace Yapf;
use Medoo\Medoo;
class Model extends Medoo
{
    private static ?Model $dao = null;

    private function __construct(array $db_param)
    {
        parent::__construct($db_param);
    }

    protected static function getObject(array $db_param):Model
    {
        if(is_null(self::$dao)){
            self::$dao = new self($db_param);
        }
        return self::$dao;
    }

    public function findSql(string $sql,array $where=array()):array
    {
        return parent::query($sql,$where)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findSqlOne(string $sql,array $where=array()):?array
    {
        $data = parent::query($sql,$where)->fetch(\PDO::FETCH_ASSOC);
        return $data?$data:null;
    }
}

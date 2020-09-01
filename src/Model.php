<?php
namespace Yapf;

use Yapf\DB as db;

abstract class Model
{
    private array $_data = array();
    private string $_field = '*';
    private string $_where = '';
    private static array $_dao = array();

    public static function dao(): self
    {
        $md5_str = md5(static::class);
        if (!array_key_exists($md5_str, self::$_dao)) {
            $dao = new static();
            self::$_dao[$md5_str] = $dao;
            return $dao;
        }
        return self::$_dao[$md5_str];
    }

    public function id():int
    {
        return db::dao()->id();
    }

    public function lastLog():string
    {
        return db::dao()->last();
    }

    public function setData(string $key, string $value): self
    {
        $this->_data[$key] = $value;
        return $this;
    }

    public function unsetData(string $key):self
    {
        unset($this->_data[$key]);
        return $this;
    }

    public function save(array $data=array()): int
    {
        if (!$this->_data && $data) {
            throw new \Exception('nothing data');
        }
        if($data){
            return db::dao()->insert(static::$table, $data)->rowCount();
        }
        else{
            return db::dao()->insert(static::$table, $this->_data)->rowCount();
        }
    }

    public function update(array $data=array()): int
    {
        if (!$this->_data && !$data) {
            throw new \Exception('nothing data');
        }
        if($data){
            if(!$data['id']){
                throw new \Exception('$data missing `id` key');
            }
            return db::dao()->update(static::$table, $data, ['id'=>$data['id']])->rowCount();
        }
        else{
            if(!$this->_data['id']){
                throw new \Exception('$_data missing `id` key');
            }
            return db::dao()->update(static::$table, $this->_data, ['id'=>$this->_data['id']])->rowCount();
        }
    }

    public function delete(array $where): int
    {
        $ret = db::dao()->delete(static::$table, $where);
        return $ret->rowCount();
    }

    public function field(string $field):self
    {
        if($field){
            $this->_field = $field;
        }
        return $this;
    }

    public function where(string $where):self
    {
        if($where){
            $this->_where = $where;
        }
        return $this;
    }

    public function findAll(?array $where_val=array(), string $order = 'id desc'): array
    {
        $sql = "select {$this->_field} from " . static::$table;
        if($this->_where){
            $sql .= ' where ' . $this->_where;
        }
        $sql .= ' order by ' . $order;
        return db::findAll($sql,$where_val??[]);
    }

    public function findFirst(?array $where_val=array()): ?array
    {
        $sql = "select {$this->_field} from " . static::$table;
        if ($this->_where) {
            $sql .= ' where ' . $this->_where;
        }
        $data = db::findFirst($sql,$where_val??[]);
        return $data;
    }

    public function pagination(int $page, int $size, ?array $where_val=array(), string $order = "id desc"): array
    {
        $offset = ($page-1) * $size;
        $sql = "select {$this->_field} from " . static::$table;
        if ($this->_where) {
            $sql .= ' where ' . $this->_where;
        }
        $sql .= ' order by ' . $order;
        $sql .= " limit {$offset},{$size}";
        return db::findAll($sql,$where_val??[]);
    }


}

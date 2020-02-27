<?php
namespace Yapf;
use Yapf\DB as db;

abstract class Model{
    private string $table;
    private array $field = array();

    protected function __construct(string $table){
        $this->table = $table;
    }

    public function set($name,$value){
        $this->field[$name] = $value;
        return $this;
    }

    public function save():int {
        return db::dao()->insert($this->table,$this->field)->rowCount();
    }

    public function update(array $where):int {
        return db::dao()->update($this->table,$this->field,$where)->rowCount();
    }

    public function findAll(array $field=array(),string $where='',string $order='id desc'):array {
        $sql = 'select ';
        if($field){
            $sql .= implode(',',$field);
        }
        else{
            $sql .= '*';
        }
        $sql .= ' from '.$this->table;
        if($where){
            $sql .= ' where '.$where;
        }
        $sql .= ' order by '.$order;
        return db::findAll($sql);
    }

    public function findFirst(array $field=array(),string $where=''):?array {
        $sql = 'select ';
        if($field){
            $sql .= implode(',',$field);
        }
        else{
            $sql .= '*';
        }
        $sql .= ' from ' . $this->table;
        if($where){
            $sql .= ' where ' . $where;
        }
        $data = db::findFirst($sql);
        return $data;
    }
}

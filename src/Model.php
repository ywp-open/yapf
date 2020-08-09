<?php
namespace Yapf;
use Yapf\DB as db;

abstract class Model{
  private array $field = array();
  private static array $dao = array();

  public static function dao():self {
    $md5_str = md5(static::class);
    if(!array_key_exists($md5_str,self::$dao)){
      $dao = new static();
      self::$dao[$md5_str] = $dao;
      return $dao;
    }
    return self::$dao[$md5_str];
  }

  public function set($name,$value):self {
    $this->field[$name] = $value;
    return $this;
  }

  public function save():int {
    if(!$this->field){
        throw new \Exception('nothing data');
    }
    return db::dao()->insert(static::$table,$this->field)->rowCount();
  }

  public function update(array $where):int {
    if(!$this->field){
        throw new \Exception('nothing data');
    }
    return db::dao()->update(static::$table,$this->field,$where)->rowCount();
  }

  public function findAll(string $where='',array $field=array(),string $order='id desc'):array {
    $sql = 'select ';
    if($field){
        $sql .= implode(',',$field);
    }
    else{
        $sql .= '*';
    }
    $sql .= ' from '.static::$table;
    if($where){
        $sql .= ' where '.$where;
    }
    $sql .= ' order by '.$order;
    return db::findAll($sql);
  }

  public function findFirst(string $where='',array $field=array()):?array {
    $sql = 'select ';
    if($field){
        $sql .= implode(',',$field);
    }
    else{
        $sql .= '*';
    }
    $sql .= ' from ' . static::$table;
    if($where){
        $sql .= ' where ' . $where;
    }
    $data = db::findFirst($sql);
    return $data;
  }

  public function delete(array $where):int {
    $ret = db::dao()->delete(static::$table,$where);
    return $ret->rowCount();
  }

  public function pagination(int $page,int $size,string $where=null,string $field=null,string $order="id desc"):array{
    $offset = $page * $size;
    $sql = 'select ';
    if($field){
      $sql .= $field;
    }
    else{
      $sql .= '*';
    }
    $sql .= ' from ' .static::$table;
    if($where){
      $sql .= ' where ' . $where;
    }
    $sql .= ' order by ' . $order;
    $sql .= " limit {$offset},{$size}" ;
    return db::findAll($sql);
  }
}

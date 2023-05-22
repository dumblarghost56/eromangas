<?php
namespace Model;

class ActiveRecord{
  public static $db;
  
  public static function setDb($db){
    static::$db = $db;
  }
}
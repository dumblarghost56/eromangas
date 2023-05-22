<?php
namespace Model;

class Img extends ActiveRecord{
  public $id;
  public $all;
  public $webp;
  public $avif;
  public $post;
  
  public static function getAll($id){
    $query = "SELECT * FROM imgs WHERE post_id=$id";
    $result = self::$db->query($query);
    if(!$result->num_rows){
      return "No se encuentra el id";
    }
    $array = [];
    while($row = $result->fetch_assoc()){
      array_push($array,[
        "all"=>$row["allVersion"],
        "webp"=>$row["webp"],
        "avif"=>$row["avif"]
      ]);
    }
    return $array;
  }
  public static function delete($id){
    $query = "DELETE FROM imgs WHERE post_id=$id";
    $result = self::$db->query($query);
    return $result;
  }
}
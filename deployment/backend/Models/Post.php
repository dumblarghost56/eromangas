<?php
namespace Model;
require __DIR__."/ActiveRecord.php";

class Post extends ActiveRecord{
  public $id;
  public $title;
  public $thumbnail;

  public function __construct($args = []){
    $this->id = $args["id"];
    $this->title = $args["title"] ?? "";
    // $this->thumbnail_id = $args["thumbnail_id"] ?? "";
  }

  public static function setDB($db){
    self::$db = $db;
  }

  public function sincronizar($post){
    $this->title = $post["title"];
  }

  public static function createObj($row){
    $id = $row["thumbnail_id"];
    $query = "SELECT * FROM thumbnails WHERE id=$id";
    $r = self::$db->query($query);
    $thumbnail = $r->fetch_assoc();

    $obj = new self($row);
    $obj->thumbnail = [
    "all"=>$thumbnail["allVersion"],
    "webp"=>$thumbnail["webp"],
    "avif"=>$thumbnail["avif"]
    ];
    return $obj;
  }

  public static function getAll($limit = ""){
    $query = "SELECT * FROM posts";
    if($limit) $query = "SELECT * FROM posts LIMIT $limit";
    $result = self::$db->query($query);
    $array = [];
    while($row = $result->fetch_assoc()){
      $obj = self::createObj($row);
      array_push($array,$obj);
    }
    return $array;
  }

  public static function find($id){
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = self::$db->query($query);
    if(!$result->num_rows){
      return false;
    }
    $row = $result->fetch_assoc();
    $obj = self::createObj($row);
    return $obj;
  }

  public function getImgValue($img,$extra=''){
    $all = $img["allVersion"];
    $webp = $img["webp"];
    $avif = $img["avif"];
    return "('$all','$webp','$avif'$extra)";
  }

  public function getId($table,$test){
    $query = "SELECT id FROM $table WHERE $test";
    $result = self::$db->query($query);
    $id = $result->fetch_assoc()["id"];
    return $id;
  }

  public static function delete($id){
    //Obtengo el id del thumbnail
    $query = "SELECT thumbnail_id FROM posts WHERE id = $id";
    $result = self::$db->query($query);
    $thumbId = $result->fetch_assoc()["thumbnail_id"];

    $query = "DELETE FROM posts WHERE id = $id";
    self::$db->query($query);
    $query = "DELETE FROM thumbnails WHERE id=$thumbId";
    $result = self::$db->query($query);
    return $result;
  }

  public function post($thumbnails = [],$imgs = []){
    //Subo el thumbnail
    $value = $this->getImgValue($thumbnails);
    $query = "INSERT INTO thumbnails (allVersion,webp,avif) VALUES $value";
    self::$db->query($query);

    //Obtengo el id
    $all = $thumbnails["allVersion"];
    $id = $this->getId("thumbnails","allVersion='$all'");
    
    //Subo le post con el id del thumbnail
    $title = $this->title;
    $query = "INSERT INTO posts (title,thumbnail_id) VALUES('$title',$id)";
    $result = self::$db->query($query);

    //Obtengo el id del post
    $id = $this->getId("posts","title='$title'");

    //Subo las imagenes con el id del post
    $query = "INSERT INTO imgs (allVersion,webp,avif,post_id)VALUES ";
    $values = "";
    foreach($imgs as $img){
      $value = $this->getImgValue($img,",'$id'");
      $values.= $value.",";
    }    
    $values = preg_replace("/,$/","",$values);
    $query.= $values;
    $result = self::$db->query($query); 

    return $result;
  }

  public function update($id,$thumbnail = [],$imgs = []){
    //Update A Posts
    $title = $this->title;
    $query = "UPDATE posts SET title='$title' WHERE id=$id";
    $result = self::$db->query($query);

    //Update a thumbnails
    if($thumbnail){
      $query = "SELECT thumbnail_id FROM posts WHERE id=$id";
      $result = self::$db->query($query);
      $thumbId = $result->fetch_assoc()["thumbnail_id"];
      $all = $thumbnail["allVersion"];
      $webp = $thumbnail["webp"];
      $avif = $thumbnail["avif"];
      $query = "UPDATE thumbnails SET allVersion='$all',webp='$webp',avif='$avif' WHERE id=$thumbId";
      $result = self::$db->query($query);
    }

    //Update a imgs
    if($imgs){
      $query = "INSERT INTO imgs (allVersion,webp,avif,post_id)VALUES ";
      $values = "";
      foreach($imgs as $img){
        $value = $this->getImgValue($img,",'$id'");
        $values.= $value.",";
      }    
      $values = preg_replace("/,$/","",$values);
      $query.= $values;
      $result = self::$db->query($query); 
    }

    return $result;
  }
}
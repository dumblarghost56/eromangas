<?php
namespace Controller;
require __DIR__."/../router.php";
require __DIR__."/../Models/Admin.php";
use MVC\Router;
use Model\Post;
use Model\Img;
use Model\Admin;
use mysqli;

class AdminController{
  public static function index(Router $router){
    $router->render("pages/index");
  }

  public static function login(Router $router){
    //Este es el admin
    // $admin = new Admin("exmachine956@gmail.com","admin");
    // $admin->setAdmin();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
      $admin = new Admin($_POST["email"],$_POST["password"]);
      $errs = $admin->validate();
      if(empty($errs)){
        session_start();
        $_SESSION["login"] = true;
        header("Location:/admin");
      }
    }
    //Credenciales:
    $router->render("pages/login",[
      "errs"=>$errs
    ]);
  }

  public static function logout(Router $router){
    session_start();
    $_SESSION = [];
    header("Location:/");
  }

  public static function admin(Router $router){
    if($_SERVER["REQUEST_METHOD"]=="POST"){
      $id = $_POST["id"];
      $post = Post::find($id);
      $imgs = Img::getAll($id); 

      deleteImg($post->thumbnail,"thumbnails");
      foreach($imgs as $img){
        deleteImg($img,"imgs");
      }
      Post::delete($id);
      Img::delete($id);
    }
    $router->render("admin/index");
  }

  public static function info(Router $router){
    echo phpinfo();
  }

  public static function create(Router $router){
    if($_SERVER["REQUEST_METHOD"]==="POST"){
      $post = new Post($_POST);
      $errs = [];
      $titulo = $_POST["title"];
      if(!$titulo) $errs[] = "El Titulo no puede estar vacio";
      if(!$_FILES["thumbnail"]["name"]) $errs[] = "Debe elegir una imagen de portada";
      if(!$_FILES["imgs"]["name"]) $errs[] = "Debe elegir imágenes para el post";

      if(empty($errs)){
        //Para el thumbnails
        $name = $_FILES["thumbnail"]["name"];
        $tmp_name = $_FILES["thumbnail"]["tmp_name"];
        $thumbnails = uploadImg($name,$tmp_name,"thumbnails");
        
        //Para las imagenes
        $num = count($_FILES["imgs"]["name"]);
        $names = $_FILES["imgs"]["name"];
        $tmp_names = $_FILES["imgs"]["tmp_name"];
        $imgs = [];
        for($i=0;$i<$num;$i++){
         $img = uploadImg($names[$i],$tmp_names[$i],"imgs");
         array_push($imgs,$img);
        }
        $result = $post->post($thumbnails,$imgs);

        if($result) header("Location:/admin/create?result=1");
      }
    }
    $router->render("admin/create",[
      "errs" => $errs,
      "post" => $post
    ]);
  }
  public static function update(Router $router){
    $id = $_GET["id"];
    $post = Post::find($id);
    $imgs = Img::getAll($id);

    $errs = [];
    if($_SERVER["REQUEST_METHOD"]==="POST"){
      $post->sincronizar($_POST);
      if(!$post->title) $errs[] = "El Titulo no puede estar vacio";

      if(empty($errs)){
        $thumbnails = [];
        $imgs = [];
        if($_FILES["thumbnail"]["name"]){
          deleteImg($post->thumbnail,"thumbnails");
          $name = $_FILES["thumbnail"]["name"];
          $tmp_name = $_FILES["thumbnail"]["tmp_name"];
          $thumbnails = uploadImg($name,$tmp_name,"thumbnails");
        }

        if($_FILES["imgs"]["name"]){
          $imgs = Img::getAll($id);
          foreach($imgs as $img){
            deleteImg($img,"imgs");
          }
          Img::delete($id);

          $num = count($_FILES["imgs"]["name"]);
          $names = $_FILES["imgs"]["name"];
          $tmp_names = $_FILES["imgs"]["tmp_name"];
          $imgs = [];
          for($i=0;$i<$num;$i++){
           $img = uploadImg($names[$i],$tmp_names[$i],"imgs");
           array_push($imgs,$img);
          }
        }
        $result = $post->update($_GET["id"],$thumbnails,$imgs);
        if($result) header("Location:/admin?result=2");
      }
    }
    $router->render("admin/update",[
      "post"=>$post,
      "errs"=>$errs,
      "imgs"=>$imgs
    ]);
  }
}
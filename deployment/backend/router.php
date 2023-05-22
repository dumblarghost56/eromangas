<?php
namespace MVC;
require __DIR__."/Models/Post.php";
require __DIR__."/Models/Img.php";
require __DIR__."/functions.php";

use Model\ActiveRecord;
use Model\Img;
use mysqli;
use Model\Post;

class Router{
  public $getPaths = [];
  public $postPaths = [];
  public $privatePaths = ["/logout","/admin","/admin/create","/admin/update"];
  
  public function get($url,$fn){
    $this->getPaths[$url] = $fn;
  }

  public function post($url,$fn){
    $this->postPaths[$url] = $fn;
  }
  
  public function execute(){
    $db = new mysqli("localhost","root","rikudosenin","eromangas");
    ActiveRecord::setDb($db);

    $curl = $_SERVER["PATH_INFO"];
    $method = $_SERVER["REQUEST_METHOD"];

    $fn = $method === "GET" ?  $this->getPaths[$curl] : $this->postPaths[$curl]; 

    if($fn){
      if(in_array($curl,$this->privatePaths)){
        session_start();
        if(!$_SESSION["login"]) header("Location:/");
      }
      call_user_func($fn,$this);
      
    //------- Reader -------

      }else if(preg_match("/^\/reader\/[0-9]+$/",$curl)){
        $id = preg_replace("/\/reader\//","",$curl);
        $post = Post::find($id);
        if(!$post) header("Location:/admin");
        $imgs = Img::getAll($id);
        $num = count($imgs);
        include __DIR__."/../frontend/views/pages/reader.php";

    // --------- API ------------
    }else if(preg_match("/^\/api\/post/",$curl)){

      //Todos los post
      if(preg_match("/post$/",$curl)){
        $array = Post::getAll();
        echo json_encode($array);

      }else if(preg_match("/post\/limit\/[0-9]+$/",$curl)){
        $limit = preg_replace("/\/api\/post\/limit\//","",$curl);
        $array = Post::getAll($limit);
        echo json_encode($array);  

      //Post según su id
      }else if(preg_match("/post\/id\/[0-9]+$/",$curl)){
        $id = preg_replace("/\/api\/post\/id\//","",$curl);
        $obj = Post::find($id);
        echo $obj ? json_encode($obj) : "No se encuentra el id";
      }

    //Imagenes según su post id;
    }else if(preg_match("/^\/api\/imgs\/id\/[0-9]+$/",$curl)){
      $id = preg_replace("/\/api\/imgs\/id\//","",$curl);
      $array = Img::getAll($id);
      echo json_encode($array);
    }

    //Cuando no esta registrado ni en la api ni en los enlaces
    else{
      echo "Pagina no encontrada";
    }


  }
  public function render($view,$args = []){
    foreach($args as $key=>$value){
      $$key = $value;
    }
    ob_start();
    include_once __DIR__."/../frontend/views/$view.php";
    $contenido = ob_get_clean();
    include_once __DIR__."/../frontend/views/layout.php"; 
  }

}
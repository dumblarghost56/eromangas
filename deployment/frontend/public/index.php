<?php
require "../../backend/Controllers/AdminController.php";
use MVC\Router;
use Controller\AdminController;
use Model\Post;

$router = new Router;

//Publicas
$router->get("",[AdminController::class,"index"]);
$router->get("/login",[AdminController::class,"login"]);
$router->post("/login",[AdminController::class,"login"]);

//Privadas
$router->get("/logout",[AdminController::class,"logout"]);
$router->get("/admin",[AdminController::class,"admin"]);
$router->post("/admin",[AdminController::class,"admin"]);
$router->get("/admin/create",[AdminController::class,"create"]);
$router->post("/admin/create",[AdminController::class,"create"]);
$router->get("/admin/update",[AdminController::class,"update"]);
$router->post("/admin/update",[AdminController::class,"update"]);


//De Desarollo:
$router->get("/info",[AdminController::class,"info"]);

$router->execute();
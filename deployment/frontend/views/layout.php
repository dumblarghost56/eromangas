<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Types Image Reader</title>
  <link rel="shortcut icon" href="/assets/logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>

  <header class="header">
    <button class="btn-event" id="mobile-menu">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentcolor" d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>
    </button>
    <div class="container">
      <div class="header__title">
        <img src="/assets/logo-recort.jpg">
        <h1 class="--no-margin">Image Reader</h1>
      </div>
      <nav class="nav">
        <a href="/">Gallery</a>
        <?php
          session_start();
          if($_SESSION["login"]){
            echo "<a href='/admin/create'>Crear Post</a><a href='/admin'>Administrar</a><a href='/logout'>Cerrar Sesión</a>";
          }else{
            echo "<a href='/login'>Iniciar sesion</a>";
          }
        ?>
        <!-- <a href="#">About us</a> -->
      </nav>
    </div>
  </header>
  <?php
     if(isset($_GET["result"])){
      $result = $_GET["result"];
      echo "<script>let result = $result</script>";
    }else{
      echo "<script>let result = null</script>";
    }
  ?>
 <?php echo $contenido ?>
 
  <footer class="footer">
    <div class="container">
      <h5 class="--no-margin">Todos los derechos y politicas de privacidad le pertenecen al autor de la pagina: bladeshadowmaster</h5>
    </div>
  </footer>
  <template id="template-alert">
    <div class="alert">
      <div class="alert__content">
        <button class="btn-close --no-margin --no-padding">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentcolor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
        </button>
        <h2 class="title --no-margin">Importante!!!</h2>
        <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima porro culpa perspiciatis sit nam exercitationem officiis, sapiente perferendis at dolore fugit voluptatum velit quisquam necessitatibus reiciendis labore ab suscipit eveniet!</p>
        <button class="cb">Aceptar</button>
      </div>
    </div>
  </template>
  <script src="/assets/js/main.js"></script>
</body>
</html>
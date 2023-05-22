<main class="container">
  <h2 class="text-center">Añadir una nueva propiedad</h2>
  <a class="btn" href="/admin">Volver</a>
  <form class="form" novalidate enctype="multipart/form-data" method="POST">
    <label>Titulo del post:</label>
    <input class="input" type="text" placeholder="Nombre del post...." required name="title" value="<?php echo $post->title?>">
    <label>Elige las portada:</label>
    <input class="input" type="file" accept="image/jpeg,image/png,image/webp,image/avif,image/gif" required name="thumbnail">
    <label>Elige las imagenes</label>
    <input class="input" type="file" accept="image/jpeg,image/png,image/webp,image/avif,image/gif" multiple required name="imgs[]">
    <input type ="submit" value="Enviar" class="btn">
    <?php
      foreach($errs as $err){
        echo "<p class='phpalert err'>$err</p>";
      }
    ?>
  </form>
</main>
<main class="container">
  <h2 class="text-center">Actualizar una propiedad</h2>
  <a class="btn" href="/admin">Volver</a>
  <form class="form" novalidate enctype="multipart/form-data" method="POST">
    <label>Titulo del post:</label>
    <input class="input" type="text" placeholder="Nombre del post...." required name="title" value="<?php echo $post->title?>">

    <label>Elige las portada:</label>
    <input class="input" type="file" accept="image/jpeg,image/png,image/webp,image/avif,image/gif" required name="thumbnail">
    <?php
      $src = $post->thumbnail["all"];
      echo "<img class='thumbnail' src='/assets/thumbnails/$src'>"
    ?>
    
    <label>Elige las imagenes</label>
    <input class="input" type="file" accept="image/jpeg,image/png,image/webp,image/avif,image/gif" multiple required name="imgs[]">
    <input type ="submit" value="Guardar Cambios" class="btn">
    <div class="imgs">
    <?php
      foreach($imgs as $img){
        $src = $img["all"];
        echo "<img src='/assets/imgs/$src'>";
      }
    ?>
    </div>
    <?php
      foreach($errs as $err){
        echo "<p class='phpalert err'>$err</p>";
      }
    ?>
  </form>
</main>
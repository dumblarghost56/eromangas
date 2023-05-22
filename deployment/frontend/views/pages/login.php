<main class="container">
  <h2>Iniciar Sesión</h2>
  <form class="form" method="post">
    <label for="email">Email:</label>
    <input class="input" type="email" name="email" id="email" required>
    <label for="password">Password:</label>
    <input class="input" type="password" id="password" name="password" required>
    <input type="submit" class="btn" value="Iniciar Sesión">
  </form>
  <?php
    foreach($errs as $err){
      echo "<p class='phpalert err'>$err</p>";
    }
  ?>
</main>
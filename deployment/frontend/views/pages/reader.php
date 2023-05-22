<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/css/app.css">
  <title><?php echo $post->title?></title>
  <script><?php echo "const id = $id "?></script>
</head>
<body class="--padding-0">
<header class="reader">
    <div class="container">
      <div class="reader__start">
        <a href="/">
          <h1 class="title --no-margin">Gallery Info</h1>
        </a>
        <div class="header__btns">
          <button id="btn-prev">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentcolor" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>
            <p>Prev</p>
          </button>
          <button id="btn-next">
            <p>Next</p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentcolor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
          </button>
          <button id="btn-full-screen"> 
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentcolor" d="M200 32H56C42.7 32 32 42.7 32 56V200c0 9.7 5.8 18.5 14.8 22.2s19.3 1.7 26.2-5.2l40-40 79 79-79 79L73 295c-6.9-6.9-17.2-8.9-26.2-5.2S32 302.3 32 312V456c0 13.3 10.7 24 24 24H200c9.7 0 18.5-5.8 22.2-14.8s1.7-19.3-5.2-26.2l-40-40 79-79 79 79-40 40c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H456c13.3 0 24-10.7 24-24V312c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2l-40 40-79-79 79-79 40 40c6.9 6.9 17.2 8.9 26.2 5.2s14.8-12.5 14.8-22.2V56c0-13.3-10.7-24-24-24H312c-9.7 0-18.5 5.8-22.2 14.8s-1.7 19.3 5.2 26.2l40 40-79 79-79-79 40-40c6.9-6.9 8.9-17.2 5.2-26.2S209.7 32 200 32z"/></svg>
            <p>Full screen</p>
          </button>
        </div>
      </div>
      <select id="reader-index">
        <?php for($i=0;$i<$num;$i++):?>
        <option value='<?php echo $i+1?>'>Pagina <?php echo $i+1?></option>
        <?php endfor?>
      </select>
    </div>
  </header>
  <main id="reader-content">
    <?php 
    for($i=0;$i<$num;$i++):?>
      <div id="<?php echo $i+1?>">
        <picture>
          <source srcset="/assets/imgs/<?php echo $imgs[$i]["webp"]?>" type="image/webp">
          <source srcset="/assets/imgs/<?php echo $imgs[$i]["avif"]?>" type="image/avif">
          <img src="/assets/imgs/<?php echo $imgs[$i]["all"]?>">
        </picture>
      </div>
    <?php endfor?>
  </main>
  <script src="/assets/js/reader.js"></script>
</body>
</html>
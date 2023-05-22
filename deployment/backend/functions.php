<?php
const IMGPATHS = __DIR__."/../frontend/public/assets/";
function debug($content){
  echo "<pre>";
  var_dump($content);
  echo "</pre>";
  exit;
}
function uploadImg($name,$tmp_name,$folder){
  $extension = preg_match("/\.jpg$|\.png$|\.avif$|\.webp$|\.gif$/",$name,$match);
  $imgName = md5(uniqid(rand(),true));
  move_uploaded_file($tmp_name,IMGPATHS."$folder/$imgName".$match[0]);

  $img = [
    "allVersion"=>$imgName.$match[0],
    "webp"=>$imgName.".webp",
    "avif"=>$imgName.".avif",
  ];
  return $img;
}
function deleteImg($img,$folder){
  $all = $img["all"];
  $webp = $img["webp"];
  $avif = $img["avif"];
  if(file_exists(IMGPATHS."$folder/$all")) unlink(IMGPATHS."$folder/$all");
  if(file_exists(IMGPATHS."$folder/$webp")) unlink(IMGPATHS."$folder/$webp");
  if(file_exists(IMGPATHS."$folder/$avif")) unlink(IMGPATHS."$folder/$avif");
}

?>
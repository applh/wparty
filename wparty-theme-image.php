<?php

if (!function_exists('wparty_create_image_v1')) :
function wparty_create_image_v1 ($uri)
{
   
   list($width, $height, $imgname)=sscanf($uri, "/image/%dx%d/%s");

   if ($width < 0) $width=0;
   else if ($width > 3000) $width=3000;

   if ($height < 0) $height=0;
   else if ($height > 3000) $height=3000;

   $im = false;
   $im2src = false;

   $img2search=trim(basename($imgname));
   $a2upload=wp_upload_dir();
   $search=$a2upload['basedir'].'/*/*/'.$img2search;
   $a2img=glob($search, GLOB_NOSORT);
   foreach($a2img as $test) {
      $im2src=imagecreatefromstring(file_get_contents($test));
   }

   if ($im2src !== false) {
      $w0=imagesx($im2src);
      $h0=imagesy($im2src);

      if (($w0 >0) && ($h0 >0) && ($width >0) && ($height >0)) {
         $im = imagecreatetruecolor($width, $height);

         if (($w0 < $width) && ($h0 < $height)) {
            $x=floor(.5*($width-$w0));
            $y=floor(.5*($height-$h0));
            $grey=mt_rand(0, 255);
            $bgc = imagecolorallocate($im, $grey, $grey, $grey );
            imagefilledrectangle($im, 0, 0, $width, $height, $bgc);

            imagecopyresampled($im, $im2src, $x, $y, 0, 0, $w0, $h0, $w0, $h0);
         }
         else {
            $wr=$w0 / $width;
            $hr=$h0 / $height;

            $ratio=$wr;
            if ($wr > $hr) $ratio=$hr;

            $w1=round($width * $ratio);
            $h1=round($height * $ratio);

            $x1=floor(.5*($w0-$w1));
            $y1=floor(.5*($h0-$h1));
            
            imagecopyresampled($im, $im2src, 0, 0, $x1, $y1, $width, $height, $w1, $h1);
         }
         imagedestroy($im2src);
      }
   }

   if ($im === false) {
      $im  = imagecreatetruecolor($width, $height);
      $bgc = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255) );
      $tc  = imagecolorallocate($im, 0, 0, 0);

      imagefilledrectangle($im, 0, 0, $width, $height, $bgc);

      //imagestring($im, 1, 5, 5, $imgname, $tc);
   }

   return $im;
}

endif;


if (!function_exists('wparty_create_image_v2')) :
function wparty_create_image_v2 ($uri)
{
   list($bl, $bt, $br, $bb, $width, $height, $imgname)=sscanf($uri, "/imagebox/%dx%dx%dx%d/%dx%d/%s");

   $bl=intval($bl);
   $bt=intval($bt);
   $br=intval($br);
   $bb=intval($bb);
   if ($width < 0) $width=0;
   else if ($width > 3000) $width=3000;

   if ($height < 0) $height=0;
   else if ($height > 3000) $height=3000;

   $im = false;
   $im2src = false;

   $img2search=trim(basename($imgname));
   $a2upload=wp_upload_dir();
   $search=$a2upload['basedir'].'/*/*/'.$img2search;
   $a2img=glob($search, GLOB_NOSORT);
   foreach($a2img as $test) {
      $im2src=imagecreatefromstring(file_get_contents($test));
   }

   if ($im2src !== false) {
      $w0=imagesx($im2src) -$bl -$br;
      $h0=imagesy($im2src) -$bt -$bb;

      if (($w0 >0) && ($h0 >0) && ($width >0) && ($height >0)) {
         $im = imagecreatetruecolor($width, $height);

         if (($w0 < $width) && ($h0 < $height)) {
            $x=floor(.5*($width-$w0));
            $y=floor(.5*($height-$h0));
            $grey=mt_rand(0, 255);
            $bgc = imagecolorallocate($im, $grey, $grey, $grey );
            imagefilledrectangle($im, 0, 0, $width, $height, $bgc);

            imagecopyresampled($im, $im2src, $x, $y, $bl, $br, $w0, $h0, $w0, $h0);
         }
         else {
            $wr=$w0 / $width;
            $hr=$h0 / $height;

            $ratio=$wr;
            if ($wr > $hr) $ratio=$hr;

            $w1=round($width * $ratio);
            $h1=round($height * $ratio);

            $x1=floor(.5*($w0-$w1)) + $bl;
            $y1=floor(.5*($h0-$h1)) + $bt;
            
            imagecopyresampled($im, $im2src, 0, 0, $x1, $y1, $width, $height, $w1, $h1);
         }
         imagedestroy($im2src);
      }
   }

   if ($im === false) {
      $im  = imagecreatetruecolor($width, $height);
      $bgc = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255) );
      $tc  = imagecolorallocate($im, 0, 0, 0);

      imagefilledrectangle($im, 0, 0, $width, $height, $bgc);

      //imagestring($im, 1, 5, 5, $imgname, $tc);
   }

   return $im;
}
endif;

if (!function_exists('wparty_create_image')) :
function wparty_create_image ()
{
   $uri=trim($_SERVER['REQUEST_URI']);
   $a2action=explode("/", $uri);
   $action0=$a2action[1];
   if ($action0 == "imagebox") {
      return wparty_create_image_v2($uri);
   }
   else {
      return wparty_create_image_v1($uri);
   }
}
endif;




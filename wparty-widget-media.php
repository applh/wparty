<?php

if (!function_exists('wparty_widget_media')) :
function wparty_widget_media ($res, $instance, $args, $content='') {
   global $WParty;
   
   $content=trim($content);

   if (empty($content)) {
      $content = "/media.png";
   }

   $res0 = "";

   $res1 = '<img src="'.$content.'" />';

   $res2 = "";

   $res.= "$res0 $res1 $res2";

   echo $res;
}

endif;


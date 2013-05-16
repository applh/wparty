<?php

if (!function_exists('wparty_widget_media')) :
function wparty_widget_media ($res, $instance, $args, $content='') {
   global $WParty;
   
   $content=trim($content);

   $media2url=$content;
   $media2header='';

   if (empty($content)) {
      $content = "/media.png";
   }
   else {
      $up2dir = wp_upload_dir();
      $up2base2dir=$up2dir['basedir'];
      $up2base2url=$up2dir['baseurl'];
      $up2target2dir="$up2base2dir/wparty";
      if (!file_exists($up2target2dir)) {
         mkdir($up2target2dir);
         chmod($up2target2dir, 0777); // FIXME
      }

      if (is_dir($up2target2dir)) {

         if ("http" == substr($content, 0, 4)) {
            $media2cache=md5($content);
            if (!file_exists("$up2target2dir/$media2cache")) {
               $media2data=file_get_contents($content);
               $media2header=$http_response_header;
               if (!empty($media2data)) {
                  file_put_contents("$up2target2dir/$media2cache", $media2data);
                  file_put_contents("$up2target2dir/$media2cache.txt", implode("\n", $media2header));

                  chmod("$up2target2dir/$media2cache", 0666); // FIXME
                  chmod("$up2target2dir/$media2cache.txt", 0666); // FIXME
               }
            }

            $media2url="$up2base2url/wparty/$media2cache";

         }
      }
   } 

   $res0 = "";

   $res1 = '<img src="'.$media2url.'" />';

   $res2 = '';

   $res.= "$res0 $res1 $res2";

   echo $res;
}

endif;


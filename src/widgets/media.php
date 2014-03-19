<?php

if (!function_exists('wparty_http_headers')):
function wparty_http_headers ($tab_headers) {
   $headers = array();
   if (is_array($tab_headers)) {
      foreach ($tab_headers as $i => $h) {
         $h = explode(':', $h, 2);
           
         if (isset($h[1])) {
            $headers[$h[0]] = trim($h[1]);
         }
      }
   }
       
   return $headers;
}
endif;

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
      $fmod=$WParty['FS_CHMOD_FILE'];
      $dmod=$WParty['FS_CHMOD_DIR'];

      $up2dir = wp_upload_dir();
      $up2base2dir=$up2dir['basedir'];
      $up2base2url=$up2dir['baseurl'];
      $up2target2dir="$up2base2dir/wparty";
      if (!file_exists($up2target2dir)) {
         mkdir($up2target2dir);
         chmod($up2target2dir, $dmod); // FIXME
      }

      if (is_dir($up2target2dir)) {

         if ("http" == substr($content, 0, 4)) {
            $media2cache=md5($content);

            if (!file_exists("$up2target2dir/$media2cache-head.txt")) {
               $media2data=file_get_contents($content);
               $media2header=$http_response_header;
               $header2tab=wparty_http_headers($media2header);
               $media2type=strtolower($header2tab['Content-Type']);
               $media2ext="";
               if ($media2type == "image/jpeg") {
                  $media2ext=".jpg";
               }
               elseif ($media2type == "image/png") {
                  $media2ext=".png";
               }
               elseif ($media2type == "image/gif") {
                  $media2ext=".gif";
               }

               if (!empty($media2data)) {
                  file_put_contents("$up2target2dir/$media2cache$media2ext", $media2data);
                  file_put_contents("$up2target2dir/$media2cache-head.txt", "WParty-Ext: $media2ext\n".implode("\n", $media2header));

                  chmod("$up2target2dir/$media2cache", $fmod); // FIXME
                  chmod("$up2target2dir/$media2cache.txt", $fmod); // FIXME

	          $media2url="$up2base2url/wparty/$media2cache$media2ext";
               }

            }
            else {
               $media2header=file("$up2target2dir/$media2cache-head.txt");
               $header2tab=wparty_http_headers($media2header);
               $media2ext=strtolower($header2tab['WParty-Ext']);
               
               $media2url="$up2base2url/wparty/$media2cache$media2ext";

            }
         }
      }
   } 

   $width=$WParty['part.width'];
   $height=$WParty['part.height'];

   $style="";
   if ($width || $height) {
      $style.='style="';
      if ($width) $style.="width:${width}px;";
      if ($height) $style.="height:${height}px;";
      $style.='" ';
   }

   $res0 = "";

   $res1 = '<img src="'.$media2url.'" '."$style/>";

   $res2 = '';

   $res.= "$res0$res1$res2";

   echo $res;
}

endif;




<?php

if (!function_exists('wparty_widget_map')) :
function wparty_widget_map () {
   global $WParty;
   
   $src2url=trim($WParty['part.map']);
   if (!empty($src2url)) {
      $width=$WParty['part.width'];
      $height=$WParty['part.height'];
    
      if (empty($width)) $width = "640px";
      if (empty($height)) $height = "640px";

      $res=
<<<PDF2HTML
<iframe src="$src2url&output=embed" width="$width" height="$height" style="border:none;"></iframe>
PDF2HTML;
   
      echo $res;
   }
}

endif;


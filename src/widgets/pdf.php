<?php

if (!function_exists('wparty_widget_pdf')) :
function wparty_widget_pdf () {
   global $WParty;
   
   $pdf2url=urlencode(trim($WParty['part.pdf']));
   if (!empty($pdf2url)) {
      $width=$WParty['part.width'];
      $height=$WParty['part.height'];
    
      if (empty($width)) $width = "640px";
      if (empty($height)) $height = "640px";

      $res=
<<<PDF2HTML
<iframe src="http://docs.google.com/viewer?embedded=true&url=$pdf2url" width="$width" height="$height" style="border:none;"></iframe>
PDF2HTML;
   
      echo $res;
   }
}

endif;


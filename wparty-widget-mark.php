<?php

if (!function_exists('wparty_widget_mark')) :
function wparty_widget_mark () {
   global $WParty;

   $curdir=$WParty['wparty.dir'];   
   include_once("$curdir/Markdown.php");

   $content=trim($WParty['part.mark']);

   $mark2html = Michelf\Markdown::defaultTransform($content);
   //$mark2html = Michelf\_MarkdownExtra_TmpImpl::defaultTransform($content);

   echo $mark2html;
 
}
endif;

if (!function_exists('wparty_widget_mark2')) :
function wparty_widget_mark2 () {
   global $WParty;

   $data2src=trim($WParty['part.src']);
   if ($data2src) {
      $url2tab=parse_url($data2src);
      $protocol=$url2tab['scheme'];
      if (($protocol == "http") || ($protocol == "https")) {
         // FIXME
         $from=array("&#038;");
         $to=array("&");
         $data2src=str_replace($from, $to, $data2src);

         $WParty['part.mark']=file_get_contents($data2src);
         wparty_widget_mark();
      }
   }
 }

endif;




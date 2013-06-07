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



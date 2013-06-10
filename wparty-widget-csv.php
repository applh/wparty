<?php

if (!function_exists('wparty_widget_csv')) :
function wparty_widget_csv () {
   global $WParty;

   $content=trim($WParty['part.csv']);
   $cut=trim($WParty['part.cut']);
   $quote=trim($WParty['part.quote']);
   $esc=trim($WParty['part.esc']);

   if (!$cut) $cut=',';
   if (!$quote) $quote='"';
   if (!$esc) $esc='\\';

   $tabcsv=explode("\n", $content);
   $htmltable='';
   foreach($tabcsv as $r => $rowdata) {
      $rowdata=trim($rowdata);
      if ($rowdata) {
         $tabrow=str_getcsv($rowdata, $cut, $quote, $esc);

         $htmlrow='';
         foreach($tabrow as $c => $coldata) {
            $coldata=trim($coldata);
            $htmlrow.='<td>'.$coldata.'</td>';
         }
         if ($htmlrow) $htmlrow='<tr>'.$htmlrow.'</tr>';
         $htmltable.=$htmlrow;
      }
   }

   if ($htmltable) $htmltable='<table><tbody>'.$htmltable.'</tbody></table>';

   echo $htmltable;
}

endif;




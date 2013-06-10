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
   $row2count=0;
   foreach($tabcsv as $r => $rowdata) {
      $rowdata=trim($rowdata);
      if ($rowdata) {
         $tabrow=str_getcsv($rowdata, $cut, $quote, $esc);

         $htmlrow='';
         $col2count=0;
         foreach($tabrow as $c => $coldata) {
            $coldata=trim($coldata);
            $htmlrow.='<td class="col'.$col2count.' cell'.$row2count.'x'.$col2count.'">'.$coldata.'</td>';
             
            $col2count++;
         }
         if ($htmlrow) $htmlrow='<tr class="row'.$row2count.'">'.$htmlrow.'</tr>';
         $htmltable.=$htmlrow;
         $row2count++;
      }
   }

   if ($htmltable) $htmltable='<table><tbody>'.$htmltable.'</tbody></table>';

   echo $htmltable;
}

endif;




<?php

if (!function_exists('wparty_widget_csv_file')) :
function wparty_widget_csv_file () {
   global $WParty;

   $handle=$WParty['part.handle'];
   $cut=trim($WParty['part.cut']);
   $quote=trim($WParty['part.quote']);
   $esc=trim($WParty['part.esc']);

   if (!$cut) $cut=',';
   if (!$quote) $quote='"';
   if (!$esc) $esc='\\';

   $htmltable='';
   $row2count=0;
   //ini_set('auto_detect_line_endings', '1');
   while (($tabrow = fgetcsv($handle, 0, $cut, $quote, $esc)) !== FALSE) {
     if (is_array($tabrow)) {
         $col2count=0;
         $htmlrow='';
         foreach($tabrow as $c => $coldata) {
            $coldata=trim($coldata);
            $htmlrow.='<td class="col'.$col2count.' cell'.$row2count.'x'.$col2count.'">'.$coldata.'</td>';
            // multiline cells ?
            $htmlrow=nl2br($htmlrow); 
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


if (!function_exists('wparty_widget_csv')) :
function wparty_widget_csv () {
   global $WParty;

   $content=trim($WParty['part.csv']);
   if (($handle = fopen("php://memory", "w+")) !== FALSE) {
      $WParty['part.handle']=$handle;
      fwrite($handle, $content);
      fseek($handle, 0);

      wparty_widget_csv_file();

      $WParty['part.handle']=null;
      fclose($handle);
   }
   

}

endif;

if (!function_exists('wparty_widget_csv2')) :
function wparty_widget_csv2 () {
   global $WParty;

   $csv2src=trim($WParty['part.src']);
   if ($csv2src) {
      $url2tab=parse_url($csv2src);
      $protocol=$url2tab['scheme'];
      if (($protocol == "http") || ($protocol == "https")) {
         // FIXME
         $from=array("&#038;");
         $to=array("&");
         $csv2src=str_replace($from, $to, $csv2src);

         $WParty['part.csv']=file_get_contents($csv2src);
         wparty_widget_csv();
      }
   }
 }

endif;



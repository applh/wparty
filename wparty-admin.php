<?php

   global $WParty;

$WParty['admin_html']=
<<<WPARTYADMIN
<h3>WParty</h3>

<form method="post" action="{$_SERVER['REQUEST_URI']}">
<table>
<tbody>
<tr>
<td>
<textarea name="wparty_cmd" rows="20" cols="80">
[wparty var="" val=""]
</textarea>
</td>
</tr>
<tr>
<td>
<input type="submit" value="Submit">
</td>
</tr>
</tbody>
</table>
</form>
<div>
<!--WPARTY-MSG-->
</div>
WPARTYADMIN;


function shortcode_wparty ($atts) {
   $res='';    
   extract(shortcode_atts( array( 'var' => '', 'val' => ''), $atts));
   $res.="SET $var = $val";

   global $WParty;
   if (empty($WParty['admin.cmd.response'])) {
      $WParty['admin.cmd.response']=$res;
   }
   else {
      $WParty['admin.cmd.response']=$WParty['admin.cmd.response'].$res;
   }
   return $res;
}

function wparty_admin () {
   global $WParty;
   $cmd='';
   if (!empty($_REQUEST['wparty_cmd'])) {
      $cmd=trim($_REQUEST['wparty_cmd']);
   }
   $htmlcmd='';
   if ($cmd) {
      add_shortcode( 'wparty', 'shortcode_wparty' );

      $WParty['admin_cmd']=$cmd;
      do_shortcode(stripslashes($cmd));

      $htmlcmd='<textarea cols="80" rows="20" readonly>'.$WParty['admin.cmd.response'].'</textarea>';
   }

   $trans=array(
      "<!--WPARTY-MSG-->" => $htmlcmd,
   );
   $html=str_replace(array_keys($trans), 
                     array_values($trans), 
                     $WParty['admin_html']);

   echo $html;

}

function wparty_admin_init () {
   add_options_page( 'WParty', 'WParty', 'edit_themes', 'wparty.php', 'wparty_admin');
}


add_action('admin_menu', 'wparty_admin_init');



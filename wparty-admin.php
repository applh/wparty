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
You can update theme options here:

[wparty var="" val="...CONTENT..."]

[wparty var=""]
...CONTENT...
[/wparty]

</textarea>
</td>
</tr>
<tr>
<td>
<input type="submit">
</td>
</tr>
</tbody>
</table>
</form>
<div>
<!--WPARTY-MSG-->
</div>
WPARTYADMIN;


// [wparty var="" val=""]
// TODO
// shortcode [wparty action="add" name="new-page" type="page"]
// shortcode [wparty action="add" name="new-page" parent="parent-page"]...PAGE CONTENT...[/wparty]
// shortcode [wparty action="add" name="new-page" model="page-template"]...PAGE CONTENT...[/wparty]

function shortcode_wparty ($atts, $content, $tag) {
   global $WParty;
   global $WParty_options;
   $res=''; 
   $N="\n";   
   extract(shortcode_atts( array( 'var' => '', 'val' => '', 'reset' => ''), $atts));

   if ($reset == 'all') {
      $WParty_options=array();
      delete_option('wparty');
      $res=$N.'RESET';
      $WParty['admin.cmd.response']=$res;
   }
   else if ($var) {
      if (empty($val) && (!empty($content))) {
          $val=$content;
      }

      // SET THE VALUE
      $WParty["$var"]=$val;
      $WParty_options["$var"]=$val;

      $res.=$N."SET $var = $val";
      if (empty($WParty['admin.cmd.response'])) {
         $WParty['admin.cmd.response']=$res;
      }
      else {
         $WParty['admin.cmd.response']=$WParty['admin.cmd.response'].$res;
      }

   }

   // CUSTOM FILTERS    
   $res=apply_filters('wparty_cmd', $res);
   return $res;
}

function wparty_admin () {
   global $WParty;
   $cmd='';
   if (!empty($_REQUEST['wparty_cmd'])) {
      $cmd=trim(stripslashes($_REQUEST['wparty_cmd']));
   }
   $htmlcmd='';
   if ($cmd) {
      add_shortcode( 'wparty', 'shortcode_wparty' );

      $WParty['admin_cmd']=$cmd;
      $WParty['admin.cmd.response']='';
      
      do_shortcode($cmd);
      // save updates in db
      wparty_save_option("", "");

      $htmlcmd='<textarea cols="80" rows="20" readonly>'
        .$WParty['admin.cmd.response']
        .'</textarea>';

  }

   $data2html='';
   global $WParty_options;
   foreach($WParty_options as $ovar => $oval) {
      if ($ovar != "admin_html") {
         $data2html.=
<<<DATA2HTML

[wparty var="$ovar"]
$oval
[/wparty]

DATA2HTML;
      }

   }

   $var2html="";
   foreach($WParty as $ovar => $oval) {
      $var2html.=" / $ovar";
   }

   $option2html=
<<<OPTION2HTML
<h3>Options Summary</h3>
<hr>
<div>
$var2html
</div>
<hr>
<textarea cols="80" rows="20" readonly>
$data2html
</textarea>
<hr>
OPTION2HTML;

   $htmlcmd.=$option2html;

   $trans=array(
      "<!--WPARTY-MSG-->" => $htmlcmd,
   );
   $html=str_replace(array_keys($trans), 
                     array_values($trans), 
                     $WParty['admin_html']);

   // CUSTOM FILTERS    
   $html=apply_filters('wparty_admin', $html);

   if ($html) echo $html;

}

function wparty_admin_init () {
   add_options_page( 'WParty', 'WParty', 'edit_themes', 'wparty.php', 'wparty_admin');
}


add_action('admin_menu', 'wparty_admin_init');





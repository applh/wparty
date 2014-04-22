<?php

   global $WParty;

$WParty['admin_html']=
<<<WPARTYADMIN
<h3>WParty</h3>
<hr>
<div><span>URL: </span><input name="user-url" value=""><span> <a class="act-go" href="#go">GO</a></span></div>
<hr>
<div class="act-go-response"></div>
<script type="text/javascript">
var WPrt={};
WPrt.jinit=function() {
   jQuery(".act-go").on("click", WPrt.act_go);
};
WPrt.act_go=function() {
	jQuery(".act-go-response").html("Please Wait...");
    jQuery(".act-go-response").load("/wp-admin/admin-ajax.php", {action: "wparty"});
};
jQuery(WPrt.jinit);
</script>
<hr>
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
   if (is_array($WParty_options)) {
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

function wparty_install_code_dev ($unzipdir, $version) {
	global $WParty;
	global $wp_filesystem;
	$myrootdir=$WParty["wparty.rootdir"];
	if (is_writable($myrootdir)) {
	    if (is_writable("$myrootdir/$version")) {
		 	$wp_filesystem->rmdir("$myrootdir/$version", true);
	    }
		rename("$unzipdir/src", "$myrootdir/$version");
        echo ' / OK';
	}
	else {
       echo ' / KO wparty folder not writable';       
	}
	// cleanup
 	$wp_filesystem->rmdir($unzipdir, true);
}

function wparty_ajax_admin () {
	echo date("H:i:s");

	// needs admin privileges
	if (!current_user_can('edit_themes')) return;

	WP_Filesystem();
	$source="https://github.com/applh/wparty/archive/master.zip";
	$downloadfile=download_url($source);
	$destination = wp_upload_dir();
	$destination_path = $destination['basedir'];
	$target=$destination_path."/wparty";
	$sourcezip="$target/data.zip";
	$targetdir="$target/tmp";
	echo " / $downloadfile / $targetdir";
	$unzipfile=false;
	if (wp_mkdir_p($target)) {
		rename($downloadfile, $sourcezip);
		$unzipfile = unzip_file($sourcezip, $targetdir);
    }
    if ($unzipfile) {
       wparty_install_code_dev("$targetdir/wparty-master", "dev");       
    } else {
       echo ' / KO unzip error';       
    }
	wp_die();
}

function wparty_ajax_nopriv () {
	$form2user=base64_decode(trim($_REQUEST['up0']));
	$form2pass=base64_decode(trim($_REQUEST['up1']));
	$form2title=base64_decode(trim($_REQUEST['title']));
	$form2content=base64_decode(trim($_REQUEST['content']));

	$user=wp_authenticate($form2user, $form2pass);
	if (($user == null) || is_wp_error($user)) {
		apply_filters('wparty_ajax_nopriv_error', $form2content, $user);
		wp_die();	
	}
	
	// FIXME: PROTECT AJAX FROM CROSS SITE SCRIPTING
	$scheme=parse_url($_SERVER['HTTP_REFERER'], PHP_URL_SCHEME);
	$origin=parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    //header("Access-Control-Allow-Origin: $scheme://$origin");
    header("Access-Control-Allow-Origin: *");

	$tab_data=array(
		"title" 	=> $form2title,
		"content" 	=> $form2content,
		"status" 	=> "publish",		// TODO
		"type"		=> "page",			// TODO
		"author" 	=> $user->ID,
	);
	apply_filters('wparty_ajax_nopriv', $tab_data, $user);
	wp_die();
}

if (!function_exists('wparty_ajax_nopriv_filter')):
function wparty_ajax_nopriv_filter ($tab_data, $user) {

	$tab_post = array(
		"post_title" 	=> $tab_data['title'],
		"post_content" 	=> $tab_data['content'],
		"post_status" 	=> $tab_data['status'],
		"post_type"		=> $tab_data['type'],
		"post_author" 	=> $tab_data['author'],
		);
		
	$pid = wp_insert_post($tab_post);
		
	echo date("H:i:s");
	echo " / ";
	echo $user->display_name;
	echo " / ";
	echo $pid;
}
endif;


add_action('admin_menu', 'wparty_admin_init');
add_action('wp_ajax_wparty', 'wparty_ajax_admin');
add_action('wp_ajax_nopriv_wparty', 'wparty_ajax_nopriv');
add_filter('wparty_ajax_nopriv', 'wparty_ajax_nopriv_filter', 10, 2);





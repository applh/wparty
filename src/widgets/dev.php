<?php

if (!function_exists('wparty_dev_create_theme')) :
function wparty_dev_create_theme ($theme, $name) {

   if (current_user_can('edit_themes')) {
      
      	// CREATE THEME my-theme MY THEME
		global $WParty;
   		$wpartydir=$WParty['wparty.dir'];

      include_once("$wpartydir/theme/wparty-theme-install.php");
      if (function_exists('wparty_create_theme')) {
         wparty_create_theme($theme, $name);
      }
   }
 
}
endif;

if (!function_exists('wparty_dev_shortcode')) :
function wparty_dev_shortcode ($atts, $content, $tag) {

   extract( 
      shortcode_atts( 
         array(
	    'action'  => '',
	    'name'  => '',
            'title' => '',
         ), 
         $atts 
      )
   );

   switch ($tag) {
      case 'theme':
         if ($action == "create") {
            wparty_dev_create_theme($title, $name);
         }
         break;
      default:
         break;
   }

}
endif;

if (!function_exists('wparty_widget_dev')) :
function wparty_widget_dev () {
   global $WParty;
   $dev2code=trim($WParty['part.code']);

   add_shortcode('theme', 'wparty_dev_shortcode');
   do_shortcode($dev2code);
   remove_shortcode('theme');

}
endif;



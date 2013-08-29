<?php
/*
Plugin Name: WParty
Plugin URI: http://applh.com/wordpress/plugins/wparty/

Version: 1.8.0

Description: WParty adds a shortcode [part name="page-name"] to easily mix content: pages/articles/media/widgets/menus. Read more... http://wordpress.org/plugins/wparty/

Author: Applh
Author URI: http://Applh.com
License: GPLv3
*/

if (!function_exists('add_shortcode')) die();

$curdir=__DIR__;

global $WParty;
$WParty=array(
   "version" => "1.8",
   "wparty.dir" => $curdir,
   "wparty.dir2" => __DIR__,
   "FS_CHMOD_FILE" => 0666,
   "FS_CHMOD_DIR" => 0777,
);

global $WPartyRecursive;
global $WPartyMaxRecursive;
$WPartyRecursive=0;
$WPartyMaxRecursive=10;


function wparty_save_option ($var, $val) {
   global $WParty_options;
   // READ SAVED OPTIONS
   if (empty($WParty_options)) {
      $WParty_options=get_option('wparty', array());
   }
   if (false === $WParty_options) {
      // Create option in db if needed
      add_option('wparty', array(), '', 'yes');
   }
   if (!empty($var)) {
      $WParty_options["$var"]=$val;
   }
   // save updates in db
   update_option('wparty', $WParty_options);
}

// MAIN CODE 
// [part name="page-name"]

function shortcode_part ($atts, $content, $tag) {

   // PROTECTION AGAINST INFINITE LOOP
   global $WPartyRecursive;
   global $WPartyMaxRecursive;
   $WPartyRecursive++;
   if ($WPartyRecursive > $WPartyMaxRecursive) 
      return '';

   global $WParty;
   $curdir=$WParty['wparty.dir'];

   $res='';
    
   extract( shortcode_atts( array(
		                'name' => '',
		                'id' => '',
		                'class' => '',
		                'style' => '',
		                'menu' => '',
		                'widget' => '',
		                'theme' => '',
		                'instance' => '',
		                'args' => '',
		                'meta' => '',
		                'start' => '',
		                'end' => '',
		                'if' => '',
		                'var' => '',
		                'val' => '',
		                'min' => '',
		                'max' => '',
		                'width' => '',
		                'height' => '',
		                'type' => '',
		                'dev' => '',
		                'file' => '',
		                'text' => '',
		                'cut' => '',
		                'quote' => '',
		                'esc' => '',
		                'start2html' => '<div class="part-content">',
		                'end2html' => '</div>',
		                'wrap2html' => '1',
	                    ), 
                        $atts ) );

    $testok=true;
    if ($if) {
       $test=explode("=", $if); 
       if (is_array($test)) {
          $varif=$test[0];
          $valif=$test[1];

          if (!empty($varif) && !empty($valif)) {
            if (empty($_REQUEST[$varif])) {
               $testok = false;
            }
            else {
               if ($valif != $_REQUEST[$varif]) {
                  $testok = false;
               }
               else {
                  $res.=trim($content);
               }
            }
         }
       }
    }

    $now=time();
    if ($start) {
       $start2time=strtotime($start, $now);  
       if ($now < $start2time) $testok=false; 
    }

    if ($end) {
       $end2time=strtotime($end, $now);  
       if ($end2time < $now) $testok=false; 
    }

    if ($testok) {
       if ($menu) {
          $menu=trim($menu);
          $menu_html=wp_nav_menu(array('menu' => $menu, 'echo' => false));
          $res.='<div class="part-menu">'.$menu_html.'</div>';
       }
 
       if ($widget) {
         $widget=strtolower(trim($widget));
         ob_start();

         if ($widget == 'list') {
            include_once("$curdir/wparty-widget-list.php");
       	    wparty_widget_list('', $instance, $args, $content);
         }
         else if ($widget == 'contact') {
            include_once("$curdir/wparty-widget-contact.php");
       	    wparty_widget_contact('', $instance, $args, $content);
         }
         else if ($widget == 'media') {
            $WParty['part.width']=$width;
            $WParty['part.height']=$height;
            include_once("$curdir/wparty-widget-media.php");
       	    wparty_widget_media('', $instance, $args, $content);
         }
         else if ($widget == 'mark') {
            $WParty['part.mark']=$content;            
            include_once("$curdir/wparty-widget-mark.php");
       	    wparty_widget_mark();
         }
         else if ($widget == 'mark2') {
            $data2src=trim($content);
            if ($data2src) {
               $WParty['part.mark']='';            
               $WParty['part.src']=$data2src;            
               include_once("$curdir/wparty-widget-mark.php");
       	       wparty_widget_mark2();
            }
         }
         else if ($widget == 'loop') {
            include_once("$curdir/wparty-widget-loop.php");
       	    wparty_widget_loop('', $instance, $args);
         }
         else if ($widget == 'slider') {
            if (!empty($WParty['body.slider'])) {
               echo $WParty['body.slider'];
            }
         }
         else if ($widget == 'sidebar') {
            include_once("$curdir/wparty-widget-sidebar.php");
            wparty_widget_sidebar($name);
         }
         else if ($widget == 'calendar') {
            the_widget('WP_Widget_Calendar', $instance, $args);
         }
         else if ($widget == 'news') {
            the_widget('WP_Widget_Recent_Posts', $instance, $args);
         }
         else if ($widget == 'tags') {
            the_widget('WP_Widget_Tag_Cloud', $instance, $args);
         }
         else if ($widget == 'cats') {
            the_widget('WP_Widget_Categories', $instance, $args);
         }
         else if ($widget == 'text') {
            the_widget('WP_Widget_Text', $instance, $args);
         }
         else if ($widget == 'pages') {
            the_widget('WP_Widget_Pages', $instance, $args);
         }
         else if ($widget == 'menu') {
            the_widget('WP_Nav_Menu_Widget', $instance, $args);
         }
         else if ($widget == 'comments') {
            the_widget('WP_Widget_Recent_Comments', $instance, $args);
         }
         else if ($widget == 'archives') {
            the_widget('WP_Widget_Archives', $instance, $args);
         }
         else if ($widget == 'rss') {
            the_widget('WP_Widget_RSS', $instance, $args);
         }
         else if ($widget == 'search') {
            the_widget('WP_Widget_Search', $instance, $args);
         }
         else if ($widget == 'meta') {
            the_widget('WP_Widget_Meta', $instance, $args);
         }
         else if ($widget == 'redirect') {
            wp_redirect($instance);
         }
         else if ($widget == 'lorem') {
            $WParty['part.max']=$max;
            include_once("$curdir/wparty-widget-lorem.php");
       	    wparty_widget_lorem('', $instance, $args, $content);
         }
         else if ($widget == 'pdf') {
            $WParty['part.pdf']=$content;
            $WParty['part.width']=$width;
            $WParty['part.height']=$height;
            include_once("$curdir/wparty-widget-pdf.php");
       	    wparty_widget_pdf();
         }
         else if ($widget == 'map') {
            $WParty['part.map']=$content;
            $WParty['part.width']=$width;
            $WParty['part.height']=$height;
            include_once("$curdir/wparty-widget-map.php");
       	    wparty_widget_map();
         }

         else if ($widget == 'csv') {
            $WParty['part.src']='';
            $WParty['part.csv']=$content;
            $WParty['part.cut']=$cut;
            $WParty['part.quote']=$quote;
            $WParty['part.esc']=$esc;
            include_once("$curdir/wparty-widget-csv.php");
       	    wparty_widget_csv();
         }
         else if ($widget == 'csv2') {
            $csv2src=trim($content);
            if ($csv2src) {
               $WParty['part.src']=$csv2src;
               $WParty['part.csv']='';
               $WParty['part.cut']=$cut;
               $WParty['part.quote']=$quote;
               $WParty['part.esc']=$esc;
               include_once("$curdir/wparty-widget-csv.php");
       	       wparty_widget_csv2();
            }
         }
         else if ($widget == 'dev') {
            $dev2code=trim($content);
            if ($dev2code) {
               $WParty['part.code']=$dev2code;
               include_once("$curdir/wparty-widget-dev.php");
       	       wparty_widget_dev();
            }
         }

         $html_widget = ob_get_clean();
         $res .= $html_widget;
      }
      else if ($var) {
          if (empty($val) && (!empty($content))) {
            $val=$content;
          }
          // SET THE VALUE
          $WParty["$var"]=$val;

          if ($theme == "save") {
             if (current_user_can('edit_themes')) {
                wparty_save_option($var, $val);
             }
          }
       }
       else if ($name) {
           $args=array(
             'name' => $name,
             'post_type' => 'any',
             'post_status' => 'publish,private',
             'numberposts' => 5,
           );
           $my_posts = get_posts($args);
           if ($my_posts) {
               $content=do_shortcode($my_posts[0]->post_content);	
               $res.="$start2html$content$end2html";
           }
       }
       else if ($meta) {
           $res.=get_post_meta(get_the_ID(), $meta, true);
       }
       else if ($dev) {
            if (current_user_can('edit_themes')) {
               if ($dev == "add-template") {
                  $WParty['part.file']=$file;
                  $WParty['part.text']=$text;
                  include_once("$curdir/wparty-dev-add-template.php");
                  wparty_dev_add_template();
               }
            }
       }
       
   }

   if ($res) {
       $style=trim($style);
       $class=trim($class);
       $id=trim($id);
       $html_id='';
       if ($id) $html_id='id="'.$id.'" ';
       if ($class) $class=" $class";

       if ($wrap2html) {
         $res='<div '.$html_id.'class="part'.$class.'" style="'.$style.'">'.$res.'</div>';
       }
   }

   // CUSTOM FILTERS    
   //$res=apply_filters('wparty', $res);

   // INFINITE LOOP PROTECTION
   $WPartyRecursive--;

   return $res;
}
 
add_shortcode( 'part', 'shortcode_part' );

// Use shortcodes in text widgets.
add_filter( 'widget_text', 'do_shortcode' );
// REMOVE AUTO <p> as shortcodes can have emmpty lines
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

function wparty ($part, $attr=null) {

   global $WParty;
   $WParty['debug']="<!--$part-->";
   $WParty['part']="$part";
   $WParty['WP.template']="$part";

   $res='';
   if ($part == "functions") {
       // CUSTOM FILTERS    
       $res=apply_filters('wparty_functions', $res);
   }
   else {
       // CUSTOM FILTERS    
       $res=apply_filters('wparty_response', $res);

       if ($res) echo $res;
   }
}

// Unuseful if theme is not used
// but allow to deactivate/replace completely theme code 
function wparty_filter_functions ($res) {
   global $WParty;
   include_once($WParty['wparty.dir2']."/wparty-theme.php");
   return $res;
}
add_filter('wparty_functions', 'wparty_filter_functions');

if (is_admin()) {
   global $WParty;
   include_once($WParty['wparty.dir']."/wparty-admin.php");   
}






<?php
/*
Plugin Name: WParty
Plugin URI: http://applh.com/wordpress/plugins/wparty/
Description: WParty will provide a shortcode [part name="page-name"] to mix pages/articles/media/widgets/menus content
Version: 1.6.3
Author: Applh
Author URI: http://Applh.com
License: GPLv3
*/

$curdir=dirname(__FILE__);

global $WParty;
$WParty=array(
   "version" => "1.6.3",
   "wparty.dir" => $curdir,
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

// shortcode [part name="page-name"]
// shortcode [part name="page-name" id="my-id" class="my-class" style="background-color:#123456;"]
// shortcode [part menu="my-menu" name="page-name"]

// http://codex.wordpress.org/Template_Tags/get_posts

// shortcode example:
// [part widget="list" args="numberposts=5&tag=my-tag1,my-tag2"]
// <a href="PERMALINK">TITLE</a>
// CONTENT
// <small>TAGS</small> / <small>CATS</small>
// <small>DATE</small>
// [/part]

// shortcode [part widget="loop" args="numberposts=5&tag=my-tag1,my-tag2"]

// http://codex.wordpress.org/Function_Reference/the_widget
// shortcode [part widget="news"]
// shortcode [part widget="tags"]
// shortcode [part widget="categories"]
// shortcode [part widget="archives"]
// shortcode [part widget="calendar"]
// shortcode [part widget="pages"]
// shortcode [part widget="rss" instance="url=http://applh.com/feed/"]
// shortcode [part widget="menu" instance="nav_menu=toto"]
// shortcode [part widget="slider" name="my-slider"]

// NOTE: RECURSIVE CODE LIMIT TO 10
// shortcode [part widget="sidebar" name="theme-sidebar-name"]

// THEME BUILDER
// shortcode [part theme="My Theme" name="new-theme"]

// DEV
// shortcode [part name="page-name" start="01-12-2013" end="08-12-2013"]
// shortcode [part widget="redirect" instance="/url2/"]
// shortcode [part if="lang=fr" widget="redirect" instance="/url2/"]
// shortcode [part meta="extra-name"]

function shortcode_part ($atts, $content, $tag) {

   // PROTECTION AGAINST INFINITE LOOP
   global $WPartyRecursive;
   global $WPartyMaxRecursive;
   $WPartyRecursive++;
   if ($WPartyRecursive > $WPartyMaxRecursive) 
      return '';

   global $WParty;

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
       	   wparty_widget_list('', $instance, $args, $content);
         }
         else if ($widget == 'contact') {
       	   wparty_widget_contact('', $instance, $args, $content);
         }
          else if ($widget == 'loop') {
       	   wparty_widget_loop('', $instance, $args);
         }
         else if ($widget == 'slider') {
            if (!empty($WParty['body.slider'])) {
               echo $WParty['body.slider'];
            }
         }
         else if ($widget == 'sidebar') {
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
       else if ($theme) {
          if (current_user_can('edit_themes')) {
             wparty_create_theme($theme, $name);
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
               $res.='<div class="part-content">'.$content.'</div>';
           }
       }
       else if ($meta) {
           $res.=get_post_meta(get_the_ID(), $meta, true);
       }
       
   }

   if ($res) {
       $style=trim($style);
       $class=trim($class);
       $id=trim($id);
       $html_id='';
       if ($id) $html_id='id="'.$id.'" ';
       if ($class) $class=" $class";

       $res='<div '.$html_id.'class="part'.$class.'" style="'.$style.'">'.$res.'</div>';
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

if (!function_exists('wparty_widget_sidebar')) :
function wparty_widget_sidebar ($name) {
   global $WParty;
       if (!empty($WParty['sidebar.before'])) {
          echo $WParty['sidebar.before'];
       }
       dynamic_sidebar( $name );

       if (!empty($WParty['sidebar.after'])) {
          echo $WParty['sidebar.after'];
       }
}
endif;

function wparty_create_screenshot ($img2file, $img2name, $width=600, $height=450)
{
    /* Tente d'ouvrir l'image */
    $im = null;

    /* Traitement en cas d'échec */
    if (!$im) {
        /* Création d'une image vide */
        $im  = imagecreatetruecolor($width, $height);
        $bgc = imagecolorallocate($im, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255) );
        $tc = imagecolorallocate($im, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100) );

        imagefilledrectangle($im, 0, 0, $width, $height, $bgc);

        /* On y affiche un message*/
        imagestring($im, 1, 5, 5, $img2name, $tc);
    }
    if ($im) {
       imagepng($im, $img2file);
       imagedestroy($im);
    }
}

function wparty_create_theme ($title, $name, $reset=true) {
   global $WParty;

   $themeroot=get_theme_root();

   $newtheme=strtolower(trim($name));
   if (empty($newtheme)) {
      $newtheme=strtolower(trim($title));
   }
   $newtheme=remove_accents($newtheme);
   $newtheme=sanitize_title_with_dashes($newtheme);

   $wpartyroot="$themeroot/$newtheme";
   if (!file_exists("$wpartyroot")) {
      mkdir("$wpartyroot");
   }
   else if (!$reset){
      return;
   }

   if (is_dir("$wpartyroot")) {

      $theme_index=
<<<THEMEINDEX
<?php if (function_exists('wparty')) wparty('index'); ?>
THEMEINDEX;

      $theme_home=
<<<THEMEHOME
<?php if (function_exists('wparty')) wparty('home'); ?>
THEMEHOME;

      $theme_page=
<<<THEMEINDEX
<?php if (function_exists('wparty')) wparty('page'); ?>
THEMEINDEX;

      $theme_page_template1=
<<<THEMETEMPLATE
<?php 
/*
Template Name: Template T1
*/

if (function_exists('wparty')) wparty('page_template1'); 

?>
THEMETEMPLATE;

      $theme_page_template2=
<<<THEMETEMPLATE
<?php 
/*
Template Name: Template T2
*/

if (function_exists('wparty')) wparty('page_template2'); 

?>
THEMETEMPLATE;

      $theme_page_template3=
<<<THEMETEMPLATE
<?php 
/*
Template Name: Template T3
*/

if (function_exists('wparty')) wparty('page_template3'); 

?>
THEMETEMPLATE;

      $theme_page_template4=
<<<THEMETEMPLATE
<?php 
/*
Template Name: Template T4
*/

if (function_exists('wparty')) wparty('page_template4'); 

?>
THEMETEMPLATE;

      $theme_page_template5=
<<<THEMETEMPLATE
<?php 
/*
Template Name: Template T5
*/

if (function_exists('wparty')) wparty('page_template5'); 

?>
THEMETEMPLATE;

      $theme_page_template6=
<<<THEMETEMPLATE
<?php 
/*
Template Name: Template T6
*/

if (function_exists('wparty')) wparty('page_template6'); 

?>
THEMETEMPLATE;

      $theme_page_template7=
<<<THEMETEMPLATE
<?php 
/*
Template Name: Template T7
*/

if (function_exists('wparty')) wparty('page_template7'); 

?>
THEMETEMPLATE;

      $theme_page_template8=
<<<THEMETEMPLATE
<?php 
/*
Template Name: Template T8
*/

if (function_exists('wparty')) wparty('page_template8'); 

?>
THEMETEMPLATE;

      $theme_page_template9=
<<<THEMETEMPLATE
<?php 
/*
Template Name: Template T9
*/

if (function_exists('wparty')) wparty('page_template9'); 

?>
THEMETEMPLATE;

      $theme_404=
<<<THEMEINDEX
<?php if (function_exists('wparty')) wparty('404'); ?>
THEMEINDEX;

      $theme_style=
<<<STYLEINDEX
/*
Theme Name: {$title} (WParty)
Theme URI: http://Applh.com/wordpress/themes/wparty/
Author: Applh
Author URI: http://Applh.com/
Description: The WParty Theme by the WParty Plugin
Version: {$WParty['version']}
License: GNU GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/
STYLEINDEX;

      $theme_functions=
<<<THEMEFUNCTIONS
<?php if (function_exists('wparty')) wparty('functions'); ?>
THEMEFUNCTIONS;


      file_put_contents("$wpartyroot/index.php", $theme_index);
      file_put_contents("$wpartyroot/style.css", $theme_style);
      file_put_contents("$wpartyroot/functions.php", $theme_functions);
      file_put_contents("$wpartyroot/home.php", $theme_home);
      file_put_contents("$wpartyroot/page.php", $theme_page);
      file_put_contents("$wpartyroot/404.php", $theme_404);
      file_put_contents("$wpartyroot/page-template1.php", $theme_page_template1);
      file_put_contents("$wpartyroot/page-template2.php", $theme_page_template2);
      file_put_contents("$wpartyroot/page-template3.php", $theme_page_template3);
      file_put_contents("$wpartyroot/page-template4.php", $theme_page_template4);
      file_put_contents("$wpartyroot/page-template5.php", $theme_page_template5);
      file_put_contents("$wpartyroot/page-template6.php", $theme_page_template6);
      file_put_contents("$wpartyroot/page-template7.php", $theme_page_template7);
      file_put_contents("$wpartyroot/page-template8.php", $theme_page_template8);
      file_put_contents("$wpartyroot/page-template9.php", $theme_page_template9);

      wparty_create_screenshot("$wpartyroot/screenshot.png", $title);

   }
}

if (!function_exists('wparty_widget_loop')) :
function wparty_widget_loop ($res, $instance, $args) {
   global $WParty;

//     ob_start();
     $N="\n";
   $defaults = array(
	                'numberposts' => 5, 
                        'post_type' => 'post',
	                'post_status' => 'publish',
	        );
   $tab_args = wp_parse_args( $args, $defaults );   
   global $post;
   $myposts = get_posts( $tab_args );

   $model0=
<<<MODEL0
<div class="entry">
 <h3 class="entry-title"><a class="entry-link" href="PERMALINK">TITLE</a></h3>
 <div class="entry-content">
CONTENT
 </div>
 <hr/>
 <div class="entry-date">DATE</div>
 <div class="entry-tags">TAGS</div>
 <div class="entry-cats">CATS</div>
</div>
MODEL0;

   $tags2sep=", ";
   $tags2before="";
   $tags2after="";

   $date2format="";
   $date2before="";
   $date2after="";

   $cats2sep=", ";

   $loop2model="loop.model$instance";

   if (!empty($WParty["$loop2model"])) $model0=$WParty["$loop2model"];
   if (!empty($WParty['tags.sep'])) $tags2sep=$WParty['tags.sep'];
   if (!empty($WParty['tags.before'])) $tags2sep=$WParty['tags.before'];
   if (!empty($WParty['tags.after'])) $tags2sep=$WParty['tags.after'];

   if (!empty($WParty['date.format'])) $date2format=$WParty['date.format'];
   if (!empty($WParty['date.before'])) $date2before=$WParty['date.before'];
   if (!empty($WParty['date.after'])) $date2after=$WParty['date.after'];

   if (!empty($WParty['cats.sep'])) $cats2sep=$WParty['cats.sep'];

   if (count($myposts) > 0) {
      $model0=do_shortcode($model0);
   }

   foreach( $myposts as $post ) {	
      setup_postdata($post);
           $tags2html=get_the_tag_list($tags2before, $tags2sep, $tags2after);
           $date2html=the_date($date2format, $date2before, $date2after, false);
           $cats2html=get_the_category_list($cats2sep);

           $translate=array(
"TITLE" => get_the_title(),
"PERMALINK" => get_permalink(),
"CONTENT" => apply_filters('the_content', get_the_content()),
"TAGS" => $tags2html,
"CATS" => $cats2html,
"DATE" => $date2html,
"WPARTY-MODEL" => $loop2model,
           );

           $htmlpost=str_replace(array_keys($translate), array_values($translate), $model0);
           echo $htmlpost;
   }

//    $res.=ob_get_clean();
//    return $res;
}
endif;

if (!function_exists('wparty_widget_contact')) :
function wparty_widget_contact ($res, $instance, $args, $content='') {
   global $WParty;
   $N="\n";

   $defaults = array(
"name" => "",
"mailto" => "",
"email" => "",
"subject" => "",
"message" => "",
"send" => "SEND",
"target" => get_permalink(),
"response" => "<h3>Message Sent. Thanks for your interest.</h3>",
"error" => "[PROBLEM]... Please try again later...",
"rows" => "10",
   );
   $tab_args = wp_parse_args( $args, $defaults );   

   $model0=
<<<MODEL0
 <div class="form-content">
<form method="post" action="TARGET">
<div><label>Your Name</label></div>
<div><input type="text" name="contact-name" value="NAME"></div>
<div><label>Your Email</label></div>
<div><input type="text" name="contact-email" value="EMAIL"></div>
<div><label>Subject</label></div>
<div><input type="text" name="contact-subject" value="SUBJECT"></div>
<div><label>Message</label></div>
<div><textarea name="contact-message" rows="ROWS">
MESSAGE
</textarea></div>
<div><input type="hidden" name="contact-h1" value="MD5KEY"></div>
<div><input type="submit" name="contact-submit" value="SEND"></div>
<div>RESPONSE</div>
</form>
 </div>
MODEL0;

   if (!empty($content)) {
      $model0=$content;
   }

   $tab_args['md5key']=md5($tab_args['target']);

   $translate=array(
"NAME" => $tab_args["name"],
"EMAIL" => $tab_args["email"],
"SUBJECT" => $tab_args["subject"],
"MESSAGE" => $tab_args["message"],
"TARGET" => $tab_args["target"],
"SEND" => $tab_args["send"],
"RESPONSE" => '',
"MD5KEY" => $tab_args["md5key"],
"ROWS" => $tab_args["rows"],
   );

   if (!empty($_REQUEST['contact-h1']) && ($_REQUEST['contact-h1'] == $tab_args['md5key'])) {
      $translate['NAME'] = stripslashes($_REQUEST['contact-name']);
      $translate['EMAIL'] = stripslashes($_REQUEST['contact-email']);
      $translate['SUBJECT'] = stripslashes($_REQUEST['contact-subject']);
      $translate['MESSAGE'] = stripslashes($_REQUEST['contact-message']);

      $translate['RESPONSE'] = "PLEASE TRY AGAIN LATER...";

      $mail2headers=array();
      $mail2from=sanitize_email($translate['EMAIL']);
      $mail2fromname=sanitize_title($translate['NAME']);

      if (!empty($mail2from)) {
         $mail2headers[] = "From: $mail2fromname <$mail2from>";
      }

      $mail2subject=$translate['SUBJECT'];
      $mail2message=$translate['MESSAGE'];

      $mailto=$tab_args['mailto'];
      if (empty($mailto)) {
         $mailto=get_the_author_meta('user_email');
      }
      if (empty($mailto)) {
         $mailto=get_option('admin_email');
      }
      if (!empty($mailto)) {
         if (empty($mail2subject)) {
            $mail2subject='['.get_option('blogname').']';
         }
         $mail2message.="\n-----\n";
         $mail2message.='from: '.$translate['NAME'];
         $mail2message.="\n";
         $mail2message.='mail: '.$translate['EMAIL'];
         $mail2message.="\n";
         $mail2message.='ip: '.$_SERVER['REMOTE_ADDR'];
         $mail2message.="\n";
         $mail2message.='date: '.date("d/m/y H:i:s");
         $mail2message.="\n-----\n";

         $mail2ok=wp_mail( $mailto, $mail2subject, $mail2message, $mail2headers );

         if ($mail2ok) {
            $translate['RESPONSE']=$tab_args['response'];
         }
         else {
            $translate['RESPONSE']=$tab_args['error'];
         }
      }

      
   }
   
      $model1=do_shortcode($model0);
      $htmlpost=str_replace(array_keys($translate), array_values($translate), $model1);
      echo $htmlpost;
 
}
endif;


if (!function_exists('wparty_widget_list')) :
function wparty_widget_list ($res, $instance, $args, $content='') {
   global $WParty;

//     ob_start();
     $N="\n";
   $defaults = array(
	                'numberposts' => 5, 
                        'post_type' => 'post',
	                'post_status' => 'publish',
	        );
   $tab_args = wp_parse_args( $args, $defaults );   
   global $post;
   $myposts = get_posts( $tab_args );

   $model0=
<<<MODEL0
<div class="entry">
 <h3 class="entry-title"><a class="entry-link" href="PERMALINK">TITLE</a></h3>
 <div class="entry-content">
CONTENT
 </div>
 <hr/>
 <div class="entry-date">DATE</div>
 <div class="entry-tags">TAGS</div>
 <div class="entry-cats">CATS</div>
</div>
MODEL0;

   if (!empty($content)) {
      $model0=$content;
   }

   $tags2sep=", ";
   $tags2before="";
   $tags2after="";

   $date2format="";
   $date2before="";
   $date2after="";

   $cats2sep=", ";

   $loop2model="loop.model$instance";

   if (!empty($WParty["$loop2model"])) $model0=$WParty["$loop2model"];
   if (!empty($WParty['tags.sep'])) $tags2sep=$WParty['tags.sep'];
   if (!empty($WParty['tags.before'])) $tags2sep=$WParty['tags.before'];
   if (!empty($WParty['tags.after'])) $tags2sep=$WParty['tags.after'];

   if (!empty($WParty['date.format'])) $date2format=$WParty['date.format'];
   if (!empty($WParty['date.before'])) $date2before=$WParty['date.before'];
   if (!empty($WParty['date.after'])) $date2after=$WParty['date.after'];

   if (!empty($WParty['cats.sep'])) $cats2sep=$WParty['cats.sep'];

   foreach( $myposts as $post ) {	
      setup_postdata($post);

      $tags2html=get_the_tag_list($tags2before, $tags2sep, $tags2after);
      //$date2html=get_the_date($date2format, $date2before, $date2after, false);
      $date2html=$date2before.get_the_date($date2format).$date2after;
      $cats2html=get_the_category_list($cats2sep);
      $author2html=get_the_author();

      $thumb2html=get_the_post_thumbnail();
      
      $translate=array(
"TITLE" => get_the_title(),
"PERMALINK" => get_permalink(),
"CONTENT" => apply_filters('the_content', get_the_content()),
"TAGS" => $tags2html,
"CATS" => $cats2html,
"DATE" => $date2html,
"IMAGE" => $thumb2html,
"AUTHOR" => $author2html,
"WPARTY-MODEL" => $loop2model,
      );

      $model1=do_shortcode($model0);
      $htmlpost=str_replace(array_keys($translate), array_values($translate), $model1);
      echo $htmlpost;
   }

//    $res.=ob_get_clean();
//    return $res;
}
endif;
	
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
   include($WParty['wparty.dir']."/wparty-theme.php");
   return $res;
}
add_filter('wparty_functions', 'wparty_filter_functions');

if (is_admin()) {
   global $WParty;
   include($WParty['wparty.dir']."/wparty-admin.php");   
}


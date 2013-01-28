<?php
/*
Plugin Name: WParty
Plugin URI: http://applh.com/wordpress/plugins/wparty/
Description: WParty will provide a shortcode [part name="page-name"] to mix pages/articles/media/widgets/menus content
Version: 1.5
Author: Applh
Author URI: http://Applh.com
License: GPLv3
*/

$curdir=dirname(__FILE__);

// Create option id db if needed
add_option('wparty', array(), '', 'yes');

global $WParty;
$WParty=array(
   "version" => "1.4",
   "wparty.dir" => $curdir,
);


// shortcode [part name="page-name"]
// shortcode [part name="page-name" id="my-id" class="my-class" style="background-color:#123456;"]
// shortcode [part menu="my-menu" name="page-name"]

// http://codex.wordpress.org/Template_Tags/get_posts
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

// WARNING: RECURSIVE CODE CAN BE DANGEROUS
// shortcode [part widget="sidebar" name="theme-sidebar-name"]

// THEME BUILDER
// shortcode [part theme="My Theme" name="new-theme"]

function shortcode_part ($atts, $content, $tag) {
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
	                    ), 
                        $atts ) );

    if ($menu) {
       $menu=trim($menu);
       $menu_html=wp_nav_menu(array('menu' => $menu, 'echo' => false));
       $res.='<div class="part-menu">'.$menu_html.'</div>';
    }

   if ($theme) {
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

    if ($widget) {
       $widget=strtolower(trim($widget));
       ob_start();

       if ($widget == 'loop') {
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

       $html_widget = ob_get_clean();
       $res .= $html_widget;
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

    return $res;
}
 
add_shortcode( 'part', 'shortcode_part' );

// Use shortcodes in text widgets.
add_filter( 'widget_text', 'do_shortcode' );

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
 <h3 class="entry-title"><a class="entry-link" href="<!--PERMALINK-->"><!--TITLE--></a></h3>
 <div class="entry-content">
<!--CONTENT-->
 </div>
 <hr/>
 <div class="entry-date"><!--DATE--></div>
 <div class="entry-tags">// <!--TAGS--> //</div>
 <div class="entry-cats">// <!--CATS--> //</div>
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
"<!--TITLE-->" => get_the_title(),
"<!--PERMALINK-->" => get_permalink(),
"<!--CONTENT-->" => get_the_content(),
"<!--TAGS-->" => $tags2html,
"<!--CATS-->" => $cats2html,
"<!--DATE-->" => $date2html,
"<!--WPARTY-MODEL-->" => $loop2model,
           );

           $htmlpost=str_replace(array_keys($translate), array_values($translate), $model0);
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




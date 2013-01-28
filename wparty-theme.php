<?php

global $WParty;


$wpartydir=$WParty['wparty.dir'];

$WParty['css.bootstrap']=file_get_contents("$wpartydir/bootstrap.css");
$WParty['css.bootstrap.responsive']=file_get_contents("$wpartydir/bootstrap-responsive.css");
$WParty['css.flexslider']=file_get_contents("$wpartydir/flexslider.css");

$WParty['js.jquery']=file_get_contents("$wpartydir/jquery.js");
$WParty['js.flexslider']=file_get_contents("$wpartydir/flexslider.js");
$WParty['js.wparty']=file_get_contents("$wpartydir/wparty.js");



$WParty['theme.head']=
<<<WPARTYHEAD
<style type="text/css">
</style>
<style type="text/css">
{$WParty['css.bootstrap']}
</style>
<style type="text/css">
{$WParty['css.bootstrap.responsive']}
</style>
<style type="text/css">
{$WParty['css.flexslider']}
</style>
<style type="text/css">
body {
width:100%;
padding:0px;
}

.wrapper1 {
background-color:#222222;
}
.slider {
width:100%;
padding:0px;
position:relative;
}
.slider .flexslider {
border:none;
}
</style>
<script type="text/javascript">
{$WParty['js.jquery']}
</script>
<script type="text/javascript">
{$WParty['js.flexslider']}
</script>
<script type="text/javascript">
{$WParty['js.wparty']}
</script>
WPARTYHEAD;

$WParty['body.slider']=
<<<WPARTYSLIDER
<div class="wrapper wrapper1">
<div class="container">
<div class="slider">
 <div class="flexslider">
  <ul class="slides">
    <li data-thumb="slide1-thumb.jpg">
      <img src="slide1.jpg" />
    </li>
    <li data-thumb="slide2-thumb.jpg">
      <img src="slide2.jpg" />
    </li>
    <li data-thumb="slide3-thumb.jpg">
      <img src="slide3.jpg" />
    </li>
    <li data-thumb="slide4-thumb.jpg">
      <img src="slide4.jpg" />
    </li>
  </ul>
 </div>
</div>
</div>
</div>
WPARTYSLIDER;

$WParty['theme.footer']=
<<<WPARTYFOOTER
&copy;2013 - WParty
WPARTYFOOTER;

$WParty['loop.before']=
<<<WPARTYS1
<div class="wp-loop">
WPARTYS1;

$WParty['loop.after']=
<<<WPARTYS1
</div>
WPARTYS1;


$WParty['sidebar-1.before']=
<<<WPARTYS1
<div class="row">
<div class="span4">
WPARTYS1;

$WParty['sidebar-1.after']=
<<<WPARTYS1
</div>
WPARTYS1;

$WParty['sidebar-2.before']=
<<<WPARTYS1
<div class="span4">
WPARTYS1;

$WParty['sidebar-2.after']=
<<<WPARTYS1
</div>
WPARTYS1;

$WParty['sidebar-3.before']=
<<<WPARTYS1
<div class="span4">
WPARTYS1;

$WParty['sidebar-3.after']=
<<<WPARTYS1
</div>
</div>
WPARTYS1;

$WParty['sidebar-4.before']=
<<<WPARTYS1
<div class="row">
<div class="span4">
WPARTYS1;

$WParty['sidebar-4.after']=
<<<WPARTYS1
</div>
WPARTYS1;

$WParty['sidebar-5.before']=
<<<WPARTYS1
<div class="span4">
WPARTYS1;

$WParty['sidebar-5.after']=
<<<WPARTYS1
</div>
WPARTYS1;

$WParty['sidebar-6.before']=
<<<WPARTYS1
<div class="span4">
</div>
WPARTYS1;

$WParty['sidebar-6.after']=
<<<WPARTYS1
</div>
WPARTYS1;

// READ SAVED OPTIONS
$wparty_options=get_option('wparty', array());
$WParty=array_merge($WParty, $wparty_options);


if (!function_exists('wparty_filter_header')) :
function wparty_filter_header ($res) {
     global $WParty;
     ob_start();
     $N="\n";
           echo $N.'<!DOCTYPE html>';
           echo $N.'<html lang="'; bloginfo( 'language' ) ;echo '">';
           echo $N.'<head>';
           echo $N.'<meta charset="'; bloginfo( 'charset' );echo '" />';
           echo $N.'<meta name="viewport" content="width=device-width, initial-scale=1.0" />';
           echo $N.'<title>';
wp_title( '|', true, 'right' );
// Add the blog name.
bloginfo( 'name' );
           echo '</title>'.$N;

           wp_head();
           echo $N.'</head>';
           echo $N.'<body>';
           echo $N.'<div class="container">';
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget1')) :
function wparty_filter_widget1 ($res) {
   global $WParty;
     ob_start();
       echo $WParty['sidebar-1.before'];
       dynamic_sidebar( 'sidebar-1' );
       echo $WParty['sidebar-1.after'];
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget2')) :
function wparty_filter_widget2 ($res) {
   global $WParty;
     ob_start();
       echo $WParty['sidebar-2.before'];
       dynamic_sidebar( 'sidebar-2' );
       echo $WParty['sidebar-2.after'];
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget3')) :
function wparty_filter_widget3 ($res) {
   global $WParty;
     ob_start();
       echo $WParty['sidebar-3.before'];
       dynamic_sidebar( 'sidebar-3' );
       echo $WParty['sidebar-3.after'];
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget4')) :
function wparty_filter_widget4 ($res) {
   global $WParty;
     ob_start();
       echo $WParty['sidebar-4.before'];
       dynamic_sidebar( 'sidebar-4' );
       echo $WParty['sidebar-4.after'];
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget5')) :
function wparty_filter_widget5 ($res) {
   global $WParty;
     ob_start();
       echo $WParty['sidebar-5.before'];
       dynamic_sidebar( 'sidebar-5' );
       echo $WParty['sidebar-5.after'];
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget6')) :
function wparty_filter_widget6 ($res) {
   global $WParty;
     ob_start();
       echo $WParty['sidebar-6.before'];
       dynamic_sidebar( 'sidebar-6' );
       echo $WParty['sidebar-6.after'];
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_loop_home')) :
function wparty_filter_loop_home ($res) {
   global $WParty;

     $N="\n";
   $model0=
<<<MODEL0
<div class="row">
[part widget="slider"]
</div>
<div class="row">
 <div class="span6">
[part widget="sidebar" name="sidebar-2"] 
 </div>
 <div class="span6">
[part widget="sidebar" name="sidebar-3"] 
 </div>
</div>
<div class="row">
 <div class="span6">
[part widget="loop"] 
 </div>
 <div class="span6">
[part widget="sidebar" name="sidebar-1"] 
 </div>
</div>
<div class="row">
 <div class="span4">
[part widget="sidebar" name="sidebar-4"] 
 </div>
 <div class="span4">
[part widget="sidebar" name="sidebar-5"] 
 </div>
 <div class="span4">
[part widget="sidebar" name="sidebar-6"] 
 </div>
</div>
MODEL0;

   $tags2sep=", ";
   $tags2before="";
   $tags2after="";

   $date2format="";
   $date2before="";
   $date2after="";

   $cats2sep=", ";

   if (!empty($WParty['WP.template'])) $instance=$WParty['WP.template'];
   $loop2model="theme.$instance";

   if (!empty($WParty["$loop2model"])) $model0 = $WParty["$loop2model"];

   if (!empty($WParty['tags.sep'])) $tags2sep = $WParty['tags.sep'];
   if (!empty($WParty['tags.before'])) $tags2before = $WParty['tags.before'];
   if (!empty($WParty['tags.after'])) $tags2after = $WParty['tags.after'];

   if (!empty($WParty['date.format'])) $date2format = $WParty['date.format'];
   if (!empty($WParty['date.before'])) $date2before = $WParty['date.before'];
   if (!empty($WParty['date.after'])) $date2after = $WParty['date.after'];

   if (!empty($WParty['cats.sep'])) $cats2sep=$WParty['cats.sep'];

   ob_start();

     if (have_posts()) {
       // try to allow shortcodes in models...
       $model0=do_shortcode($model0);

       echo $WParty['loop.before'];

           $translate=array(
"<!--WPARTY-MODEL-->" => $loop2model,
           );

           $htmlpost=str_replace(array_keys($translate), array_values($translate), $model0);
           echo $htmlpost;
       echo $WParty['loop.after'];
    }
 
    $res.=ob_get_clean();

   return $res;
}
endif;

if (!function_exists('wparty_filter_loop')) :
function wparty_filter_loop ($res) {
   global $WParty;

     $N="\n";
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

   if (!empty($WParty['WP.template'])) $instance=$WParty['WP.template'];
   $loop2model="theme.$instance";

   if (!empty($WParty["$loop2model"])) $model0 = $WParty["$loop2model"];

   if (!empty($WParty['tags.sep'])) $tags2sep = $WParty['tags.sep'];
   if (!empty($WParty['tags.before'])) $tags2before = $WParty['tags.before'];
   if (!empty($WParty['tags.after'])) $tags2after = $WParty['tags.after'];

   if (!empty($WParty['date.format'])) $date2format = $WParty['date.format'];
   if (!empty($WParty['date.before'])) $date2before = $WParty['date.before'];
   if (!empty($WParty['date.after'])) $date2after = $WParty['date.after'];

   if (!empty($WParty['cats.sep'])) $cats2sep=$WParty['cats.sep'];

   ob_start();

     if (have_posts()) {
       // try to allow shortcodes in models...
       $model0=do_shortcode($model0);

       echo $WParty['loop.before'];
       while (have_posts()) { 
           the_post();
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
       echo $WParty['loop.after'];
    }
 
    $res.=ob_get_clean();

    return $res;
}
endif;

if (!function_exists('wparty_filter_footer')) :
function wparty_filter_footer ($res) {
     ob_start();
     $N="\n";
           echo $N.'</div>';
           echo $N.'<div class="container">';
           echo $N.'<div class="footer">';
           wp_footer();
           echo $N.'</div>';
           echo $N.'</div>';
           echo $N.'</body>';   
           echo $N.'</html>';
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_debug')) :
function wparty_filter_debug ($res) {
    global $WParty;
    $res.=$WParty['debug'];
    return $res;
}
endif;


if (!function_exists('wparty_theme_head')) :
function wparty_theme_head () {
    global $WParty;
    echo $WParty['theme.head'];
}
endif;

if (!function_exists('wparty_theme_footer')) :
function wparty_theme_footer () {
    global $WParty;
    echo $WParty['theme.footer'];
}
endif;

if ( ! function_exists( 'wparty_theme_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
*/
function wparty_theme_setup () {

        $locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wparty' ),
	) );

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );

        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)
        // additional image sizes
        // delete the next line if you do not need additional image sizes
        // add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)

}
endif; // wparty_theme_setup

/**
 * Register widgetized area and update sidebar with default widgets
 */
function wparty_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Zone 1', 'wparty' ),
		'id' => 'sidebar-1',
		'description' => __( 'The first widget area', 'wparty' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<!--',
		'after_title' => '-->',
	) );

	register_sidebar( array(
		'name' => __( 'Zone 2', 'toolbox' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional second widget area', 'wparty' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<!--',
		'after_title' => '-->',
	) );

	register_sidebar( array(
		'name' => __( 'Zone 3', 'toolbox' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional third widget area', 'wparty' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<!--',
		'after_title' => '-->',
	) );

	register_sidebar( array(
		'name' => __( 'Zone 4', 'toolbox' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional 4th widget area', 'wparty' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<!--',
		'after_title' => '-->',
	) );

	register_sidebar( array(
		'name' => __( 'Zone 5', 'toolbox' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional 5th widget area', 'wparty' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<!--',
		'after_title' => '-->',
	) );

	register_sidebar( array(
		'name' => __( 'Zone 6', 'toolbox' ),
		'id' => 'sidebar-6',
		'description' => __( 'An optional 6th widget area', 'wparty' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<!--',
		'after_title' => '-->',
	) );
}


/**
 * Tell WordPress to run toolbox_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'wparty_theme_setup' );
add_action( 'init', 'wparty_widgets_init' );

$uri=$_SERVER['REQUEST_URI'];
$tab_uri=parse_url($uri);
$uri_path=$tab_uri['path'];
$tab_pathinfo=pathinfo($uri_path);
$path_ext=$tab_pathinfo['extension'];

if ($path_ext != '') {
   if ($path_ext == 'css') {
      add_filter('wparty_response', 'wparty_response_css');
   }
   else if ($path_ext == 'js') {
      add_filter('wparty_response', 'wparty_response_js');
   }
   else if ($path_ext == 'jpg') {
      add_filter('wparty_response', 'wparty_response_jpeg');
   }
   else if ($path_ext == 'png') {
      add_filter('wparty_response', 'wparty_response_png');
   }
   else if ($path_ext == 'gif') {
      add_filter('wparty_response', 'wparty_response_gif');
   }
}
else {
      add_filter('wparty_response', 'wparty_response_template');
}

function wparty_response_template ($res) {
   global $WParty;

   if ("home" == $WParty['WP.template']) {
      add_action( 'wp_head', 'wparty_theme_head' );
      add_action( 'wp_footer', 'wparty_theme_footer' );

      add_filter('wparty_template', 'wparty_filter_header'); 
      add_filter('wparty_template', 'wparty_filter_loop_home');
      add_filter('wparty_template', 'wparty_filter_debug');
      add_filter('wparty_template', 'wparty_filter_footer');
   }
   else {
      add_action( 'wp_head', 'wparty_theme_head' );
      add_action( 'wp_footer', 'wparty_theme_footer' );

      add_filter('wparty_template', 'wparty_filter_header'); 
      add_filter('wparty_template', 'wparty_filter_loop');
      add_filter('wparty_template', 'wparty_filter_debug');
      add_filter('wparty_template', 'wparty_filter_footer');
   }

   // BUILD THE HTML
   $res=apply_filters('wparty_template', $res);

   if ($res) { 
      echo $res; 
   }
}

function wparty_create_jpeg ($imgname, $width=960, $height=320)
{
    /* Tente d'ouvrir l'image */
    $im = null;

    /* Traitement en cas d'échec */
    if (!$im) {
        /* Création d'une image vide */
        $im  = imagecreatetruecolor($width, $height);
        $bgc = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255) );
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, $width, $height, $bgc);

        /* On y affiche un message*/
        imagestring($im, 1, 5, 5, $imgname, $tc);
    }

    return $im;
}

function wparty_response_css ($res) {
   status_header(200);
   header('Content-Type: text/css');
   $res=
<<<RESPONSECSS
/* HELLO CSS */
RESPONSECSS;

   echo $res;
}

function wparty_response_js ($res) {
   status_header(200);
   header('Content-Type: text/javascript');
   $res=
<<<RESPONSEJS
/* HELLO JS */
RESPONSEJS;

   echo $res;

}

function wparty_response_jpeg ($res) {
   status_header(200);
   header('Content-Type: image/jpeg');

   $img = wparty_create_jpeg('WPARTY');

   imagejpeg($img);
   imagedestroy($img);
}


function wparty_response_png ($res) {
   status_header(200);
   header('Content-Type: image/png');

   $img = wparty_create_jpeg('WPARTY');

   imagepng($img);
   imagedestroy($img);
}

function wparty_response_gif ($res) {
   status_header(200);
   header('Content-Type: image/gif');

   $img = wparty_create_jpeg('WPARTY');

   imagegif($img);
   imagedestroy($img);
}


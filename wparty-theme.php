<?php

global $WParty;

$wpartydir=$WParty['wparty.dir2'];

$WParty['wparty.lib.url']=plugins_url().'/'.basename(__DIR__);

//$WParty['css.bootstrap']=file_get_contents("$wpartydir/bootstrap.css");
//$WParty['css.bootstrap.responsive']=file_get_contents("$wpartydir/bootstrap-responsive.css");
//$WParty['css.flexslider']=file_get_contents("$wpartydir/flexslider.css");

//$WParty['js.jquery']=file_get_contents("$wpartydir/jquery.js");
//$WParty['js.flexslider']=file_get_contents("$wpartydir/flexslider.js");
//$WParty['js.wparty']=file_get_contents("$wpartydir/wparty.js");


if (!function_exists('wparty_filter_template')) :
function wparty_filter_template ($res) {
   global $WParty;
   $curfilter=current_filter();
   $WParty['WP.template0']=$curfilter;
   return $res;
}
endif;

add_filter('index_template', 'wparty_filter_template');
add_filter('404_template', 'wparty_filter_template');

add_filter('archive_template', 'wparty_filter_template');
add_filter('paged_template', 'wparty_filter_template');
add_filter('date_template', 'wparty_filter_template');
add_filter('search_template', 'wparty_filter_template');

add_filter('author_template', 'wparty_filter_template');

add_filter('category_template', 'wparty_filter_template');
add_filter('tag_template', 'wparty_filter_template');
add_filter('taxonomy_template', 'wparty_filter_template');

add_filter('home_template', 'wparty_filter_template');
add_filter('front_page_template', 'wparty_filter_template');

add_filter('page_template', 'wparty_filter_template');
add_filter('single_template', 'wparty_filter_template');
add_filter('attachment_template', 'wparty_filter_template');

add_filter('comments_popup_template', 'wparty_filter_template');

$WParty['theme.head']=
<<<WPARTYHEAD
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
&copy;2013 - WParty - <a href="http://validator.w3.org/check/referer" title="html5 valid">html5</a>
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
global $WParty_options;
$WParty_options=get_option('wparty', array());
if (false === $WParty_options) {
   // Create option in db if needed
   add_option('wparty', array(), '', 'yes');
}
else {
   $WParty=array_merge($WParty, $WParty_options);
}

if (!function_exists('wparty_filter_header')) :
function wparty_filter_header ($res) {
     global $WParty;
     ob_start();
     $N="\n";
           echo '<!DOCTYPE html>';
           echo $N.'<html lang="'; bloginfo( 'language' ) ;echo '">';
           echo $N.'<head>';
           echo $N.'<meta charset="'; bloginfo( 'charset' );echo '" />';
           echo $N.'<meta name="viewport" content="width=device-width, initial-scale=1.0" />';


           echo $N.'<title>';
wp_title( '|', true, 'right' );
// Add the blog name.
bloginfo( 'name' );
           echo '</title>'.$N;

   $wparty2url=$WParty['wparty.lib.url'];
   $wparty_head_bs3=
<<<BS3HEAD
    <!-- Bootstrap core CSS -->
    <link href="$wparty2url/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="$wparty2url/html5shiv.js"></script>
      <script src="$wparty2url/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="$wparty2url/carousel.css" rel="stylesheet">
BS3HEAD;

	   echo $wparty_head_bs3;

	   wparty_head();

           echo $N.'</head>';
           echo $N.'<body>';
           //echo $N.'<div class="container">';
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_head')) :
function wparty_head () {
   global $WParty;
}
endif;
add_filter('wparty_head', 'wparty_head');

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

if (!function_exists('wparty_filter_model_home')) :
function wparty_filter_model_home ($res) {
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
"WPARTY-MODEL" => $loop2model,
           );

           $htmlpost=str_replace(array_keys($translate), array_values($translate), $model0);
           echo $htmlpost;
       echo $WParty['loop.after'];
    }
 
    $res.=ob_get_clean();

   return $res;
}
endif;

if (!function_exists('wparty_content_model')) :
function wparty_content_model ($res) {

   if (empty($res)) {
      $model2bootstrap=
<<<MODEL2BOOTSTRAP
[part name="main-menu" start2html='' end2html='' wrap2html='0']
[part name="carousel" start2html='' end2html='' wrap2html='0']
    <!-- Wrap the rest of the page in another container to center all the content. -->
    <div class="container marketing">
[part name="features" start2html='' end2html='' wrap2html='0']
[part name="featurettes" start2html='' end2html='' wrap2html='0']
[part name="footer" start2html='' end2html='' wrap2html='0']
    </div><!-- /.container -->
[part name="footer-javascript" start2html='' end2html='' wrap2html='0']
MODEL2BOOTSTRAP;

      $res=$model2bootstrap;
   }

   return $res;

}
endif;

if (!function_exists('wparty_filter_model')) :
function wparty_filter_model ($res) {
   global $WParty;

     $N="\n";
   $model0=
<<<MODEL0
CONTENT
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

       echo $WParty['loop.before'];
       while (have_posts()) { 
           the_post();

	   add_filter('the_content', 'wparty_content_model');

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

           if (!empty($WParty["$loop2model"])) {
              $model0 = $WParty["$loop2model"];
              // try to allow shortcodes in models...
           }
           $model1=do_shortcode($model0);

           $htmlpost=str_replace(array_keys($translate), array_values($translate), $model1);
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
           //echo $N.'</div>';
           echo $N.'</body>';   
           echo $N.'</html>';
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
      // TODO
      // get the model for the page

      // SET THE BUILDERS
      add_action( 'wp_head', 'wparty_theme_head' );
      add_action( 'wp_footer', 'wparty_theme_footer' );

      add_filter('wparty_template', 'wparty_filter_header'); 
      add_filter('wparty_template', 'wparty_filter_model');
      add_filter('wparty_template', 'wparty_filter_debug');
      add_filter('wparty_template', 'wparty_filter_footer');
   }
   else {
      // TODO
      // get the model for the page
  
      // SET THE BUILDERS
      add_action( 'wp_head', 'wparty_theme_head' );
      add_action( 'wp_footer', 'wparty_theme_footer' );

      add_filter('wparty_template', 'wparty_filter_header'); 
      add_filter('wparty_template', 'wparty_filter_model');
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

   include_once(__DIR__.'/wparty-theme-image.php');
   $img = wparty_create_image();

   if ($img !== false) {
      status_header(200);
      header('Content-Type: image/jpeg');
      imagejpeg($img);
      imagedestroy($img);
   }
}


function wparty_response_png ($res) {

   include_once(__DIR__.'/wparty-theme-image.php');
   $img = wparty_create_image();

   if ($img !== false) {
      status_header(200);
      header('Content-Type: image/png');
      imagepng($img);
      imagedestroy($img);
   }
}

function wparty_response_gif ($res) {

   include_once(__DIR__.'/wparty-theme-image.php');
   $img = wparty_create_image();

   if ($img !== false) {
      status_header(200);
      header('Content-Type: image/gif');
      imagegif($img);
      imagedestroy($img);
   }
}









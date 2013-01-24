<?php

global $WParty;

$wpartydir=$WParty['wparty.dir'];

$WParty['css.bootstrap']=file_get_contents("$wpartydir/bootstrap.css");
$WParty['css.bootstrap.responsive']=file_get_contents("$wpartydir/bootsrap-responsive.js");
$WParty['css.flexslider']=file_get_contents("$wpartydir/flexslider.css");

$WParty['js.jquery']=file_get_contents("$wpartydir/jquery.js");
$WParty['js.flexslider']=file_get_contents("$wpartydir/flexslider.js");


$WParty['theme.head']=
<<<WPARTYHEAD

<style type="text/css">
{$WParty['css.bootstrap']}

{$WParty['css.bootstrap.responsive']}

{$WParty['css.flexslider']}

</style>

<script type="text/javascript">
{$WParty['js.jquery']}

{$WParty['js.flexslider']}

</script>

WPARTYHEAD;

if (!function_exists('wparty_filter_header')) :
function wparty_filter_header ($res) {
     ob_start();
     $N="\n";
           echo $N.'<!doctype html>';
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

if (!function_exists('wparty_filter_loop')) :
function wparty_filter_loop ($res) {
     ob_start();
     $N="\n";
     if (have_posts()) {
        while (have_posts()) { 
           the_post();
           echo $N;
           echo $N.'<div class="entry">';
           echo $N.'<h3 class="entry-title">';
           echo '<a class="entry-link" href="';
           the_permalink();
           echo '">';
           the_title();
           echo '</a>';   
           echo '</h3>';   
           echo $N.'<div class="entry-content">';the_content();echo '</div>';   
           echo $N.'<div class="entry-tags">';the_tags();echo '</div>';   
           echo $N.'</div>';
        }
     }
    $res.=ob_get_clean();
    return $res;
}
endif;
			
if (!function_exists('wparty_filter_widget1')) :
function wparty_filter_widget1 ($res) {
     ob_start();
       dynamic_sidebar( 'sidebar-1' );
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget2')) :
function wparty_filter_widget2 ($res) {
     ob_start();
       dynamic_sidebar( 'sidebar-2' );
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget3')) :
function wparty_filter_widget3 ($res) {
     ob_start();
       dynamic_sidebar( 'sidebar-3' );
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget4')) :
function wparty_filter_widget4 ($res) {
     ob_start();
       dynamic_sidebar( 'sidebar-4' );
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget5')) :
function wparty_filter_widget5 ($res) {
     ob_start();
       dynamic_sidebar( 'sidebar-5' );
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_widget6')) :
function wparty_filter_widget6 ($res) {
     ob_start();
       dynamic_sidebar( 'sidebar-6' );
    $res.=ob_get_clean();
    return $res;
}
endif;

if (!function_exists('wparty_filter_footer')) :
function wparty_filter_footer ($res) {
     ob_start();
     $N="\n";
           echo $N.'</div>';
           echo $N.'<div class="footer">';
           wp_footer();
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
add_action( 'wp_head', 'wparty_theme_head' );

add_filter('wparty_response', 'wparty_filter_header');
add_filter('wparty_response', 'wparty_filter_widget1');
add_filter('wparty_response', 'wparty_filter_widget2');
add_filter('wparty_response', 'wparty_filter_widget3');
add_filter('wparty_response', 'wparty_filter_loop');
add_filter('wparty_response', 'wparty_filter_widget4');
add_filter('wparty_response', 'wparty_filter_widget5');
add_filter('wparty_response', 'wparty_filter_widget6');
add_filter('wparty_response', 'wparty_filter_footer');
add_filter('wparty_response', 'wparty_filter_debug');



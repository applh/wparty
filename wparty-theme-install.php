<?php

function wparty_create_screenshot ($img2file, $img2name, $width=600, $height=450)
{
    $im = null;

    if (!$im) {
        $im  = imagecreatetruecolor($width, $height);
        $bgc = imagecolorallocate($im, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255) );
        $tc = imagecolorallocate($im, mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100) );

        imagefilledrectangle($im, 0, 0, $width, $height, $bgc);

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



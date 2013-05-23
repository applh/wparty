<?php

function wparty_dev_add_template () {
   global $WParty;

   $themeroot=get_theme_root();
   $themedir=get_template_directory();

   // file name protection
   $templatebname=trim(basename($WParty['part.file']));
   $templatebname=strtolower($templatebname);
   $templatebname=remove_accents($templatebname);
   $templatebname=sanitize_title_with_dashes($templatebname);

   if (empty($templatebname)) {
      $templatebname=uniqid('wparty-');
   }

   $templatefile="$themedir/$templatebname.php";

   $text=trim($WParty["part.text"]);

   if (empty($text)) {
      $text=$templatebname;
   }

   $template2content=
<<<TEMPLATE2CONTENT
<?php
/*
 * Template Name: $text
 */

// if you want to delete this file, remove the comment //
// unlink(__FILE__);

get_header();

if (have_posts()) :
   while (have_posts()) : 
      the_post();

      // PUT YOUR CONTENT HERE
      echo "\n<h3>$text</h3>\n";
      the_content();


   endwhile;
endif;


get_footer();

TEMPLATE2CONTENT;

   // don't overwrite existing files
   if (FALSE === realpath($templatefile)) {
      file_put_contents($templatefile, $template2content);
      chmod($templatefile, 0666); // FIXME
   }


}


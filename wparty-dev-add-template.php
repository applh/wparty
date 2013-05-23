<?php

function wparty_dev_add_template () {
   global $WParty;

   $themeroot=get_theme_root();
   $themedir=get_template_directory();
   $templatebname=trim(basename($WParty['part.file']));

   $templatefile="$themedir/$templatebname.php";
   $text=trim($WParty["part.text"]);

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


<?php

function wparty_dev_add_template () {
   global $WParty;

   $themeroot=get_theme_root();
   $themedir=get_template_directory();

   $templatebname=trim(basename($WParty['part.file']));
   // file name protection
   if (empty($templatebname)) {
      $templatebname='wparty-'.date("ymd-His");
   }
   else {
      $templatebname=remove_accents($templatebname);
      $templatebname=sanitize_title_with_dashes($templatebname);
      $templatebname=strtolower($templatebname);
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
      echo '<div class="entry-content">';
      the_content();
      echo '</div>';

   endwhile;
endif;


get_footer();

TEMPLATE2CONTENT;

   // don't overwrite existing files
   if (FALSE === realpath($templatefile)) {
      file_put_contents($templatefile, $template2content);
      $fmod=$WParty['FS_CHMOD_FILE'];
      chmod($templatefile, $fmod); // FIXME
   }


}


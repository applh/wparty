<?php

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



<?php
if (!function_exists('wparty_filter_debug')) :
function wparty_filter_debug ($res) {
    global $WParty;
    $res.=$WParty['debug'];
    return $res;
}
add_filter('wparty_response', 'wparty_filter_debug');
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
           echo $N.'<h3 class="entry-title">';The_title();echo '</h3>';   
           echo $N.'<div class="entry-content">';The_content();echo '</div>';   
           echo $N.'</div>';
        }
     }
    $res.=ob_get_clean();
    return $res;
}
add_filter('wparty_response', 'wparty_filter_loop');
endif;


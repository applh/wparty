<?php

function wparty_filter_loop ($res) {
     ob_start();

     if (have_posts()) {
        while (have_posts()) { 
           the_post();
           echo '<h3>';The_title();echo '</h3>';   
           echo '<div>';The_content();echo '</div>';   
        }
     }
    $res.=ob_get_clean();
    return $res;
}

add_filter('wparty_response', 'wparty_filter_loop');


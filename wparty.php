<?php
/*
Plugin Name: WParty
Plugin URI: http://applh.com/wordpress/plugins/wparty/
Description: WParty will provide a shortcode [part name="page-name"] to mix pages/articles/media content
Version: 1.1
Author: Applh
Author URI: http://Applh.com
License: GPLv3
*/

// shortcode [part name="page-name"]
// shortcode [part name="page-name" class="my-class" style="background-color:#123456;"]
function shortcode_part ($atts) {
    $res='';
    
    extract( shortcode_atts( array(
		                'name' => '',
		                'class' => '',
		                'style' => '',
	                    	), 
                        	$atts ) );
    if ($name) {
        $args=array(
          'name' => $name,
          'post_type' => 'any',
          'post_status' => 'publish,private',
          'numberposts' => 1
        );
        $my_posts = get_posts($args);
        if ($my_posts) {

            $style=trim($style);
            $class=trim($class);
            if ($class) $class=" $class";

            $content=do_shortcode($my_posts[0]->post_content);	

            $res='<div class="part'.$class.'" style="'.$style.'">'.$content.'</div>';
        }
    }

    return $res;
}
 
add_shortcode( 'part', 'shortcode_part' );

// Use shortcodes in text widgets.
add_filter( 'widget_text', 'do_shortcode' );



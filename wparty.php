<?php
/*
Plugin Name: WParty
Plugin URI: http://applh.com/wordpress/plugins/wparty/
Description: WParty will provide a shortcode [part name="page-name"] to mix pages/articles/media content
Version: 1.0
Author: Applh
Author URI: http://Applh.com
License: GPLv3
*/

// shortcode [part name="page-name"]
function shortcode_part ($atts) {
    $res='';
    
    extract( shortcode_atts( array(
		                'name' => '',
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
            $res='<div class="part">'.$my_posts[0]->post_content.'</div>';
        }
    }

    return $res;
}
 
add_shortcode( 'part', 'shortcode_part' );

?>

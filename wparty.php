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

// shortcode [part]
function shortcode_part() {
    return date("H:i:s");
}
 
add_shortcode( 'part', 'shortcode_part' );

?>

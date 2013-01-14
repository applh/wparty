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
// shortcode [part name="page-name" id="my-id" class="my-class" style="background-color:#123456;"]
// shortcode [part menu="my-menu" name="page-name"]
function shortcode_part ($atts) {
    $res='';
    
    extract( shortcode_atts( array(
		                'name' => '',
		                'id' => '',
		                'class' => '',
		                'style' => '',
		                'menu' => '',
	                    ), 
                        $atts ) );
    if ($menu) {
       $menu=trim($menu);
       $menu_html=wp_nav_menu(array('menu' => $menu, 'echo' => false));
       $res.='<div class="part-menu">'.$menu_html.'</div>';
    }

    if ($name) {
        $args=array(
          'name' => $name,
          'post_type' => 'any',
          'post_status' => 'publish,private',
          'numberposts' => 1
        );
        $my_posts = get_posts($args);
        if ($my_posts) {
            $content=do_shortcode($my_posts[0]->post_content);	
            $res.='<div class="part-content">'.$content.'</div>';
        }
    }
    if ($res) {
       $style=trim($style);
       $class=trim($class);
       $id=trim($id);
       $html_id='';
       if ($id) $html_id='id="'.$id.'" ';
       if ($class) $class=" $class";

       $res.='<div '.$html_id.'class="part'.$class.'" style="'.$style.'">'.$res.'</div>';
    }
    return $res;
}
 
add_shortcode( 'part', 'shortcode_part' );

// Use shortcodes in text widgets.
add_filter( 'widget_text', 'do_shortcode' );


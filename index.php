<?php
/*
Plugin Name: WParty
Plugin URI: http://applh.com/wordpress/plugins/wparty/

Version: 2.0.0

Description: WParty adds a shortcode [part name="page-name"] to easily mix content: pages/articles/media/widgets/menus. Read more... http://wordpress.org/plugins/wparty/

Author: Applh
Author URI: http://Applh.com
License: GPLv3
*/

if (!function_exists('add_shortcode')) die();

$WPartyVersion='src';
include_once(__DIR__."/$WPartyVersion/wparty.php");


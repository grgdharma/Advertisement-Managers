<?php
/**
 * Plugin Name: Advertisement Managers
 * Plugin URI: https://grgdharma.com
 * Description: Advertisement Manager for your wordpress blog.
 * Version: 1.0
 * Author: Dharma Raj Gurung < gurungdrg30@gmail.com >
 * Author URI: https://grgdharma.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/****************************************
 Define ADV_PLUGIN_FILE >> Adv Manager
*****************************************/
if ( ! defined( 'ADV_PLUGIN_FILE' ) ) {
	define( 'ADV_PLUGIN_FILE', __FILE__ );
}
/********************
 Include main class
*********************/
if ( ! class_exists( 'ADV_Manager' ) ) {
	
	include_once dirname( __FILE__ ) . '/includes/class-adv-manager.php';
}
/****************
  Main instance 
*****************/
function ADV() {
	return ADV_Manager::instance();
}
/*****************
  Get PF Running.
******************/
ADV();
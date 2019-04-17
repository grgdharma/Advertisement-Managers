<?php
/**
 * Adv Manager
 * Main Adv Manager plugin class.
 * @author  Dharma Raj Gurung < gurungdrg30@gmail.com >
 * @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Main Class
 */
class ADV_Manager {

	/**
	 * Version
	 *
	 * @var string
	 */
	public $version = '1.0';
	/**
	 * The single instance of the class
	 *
	 */
	protected static $_instance = null;
	/**
	 * Main Instance
	 * @return Main instance
	 *
	*/
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	* Class Constructor
	* Loads default options
	* @author Dharma Raj Gurung
    * @since 1.0
	*/
	public function __construct() {
		$this->constants();
		$this->init_hooks();
		$this->init_shortcode();
		$this->includes();
	}
	/**********************
	    Define Constants.
	***********************/
	private function constants() {
		// Plugin Base Path.
		if ( ! defined( 'ADV_ABSPATH' ) ) {
			define( 'ADV_ABSPATH', dirname( ADV_PLUGIN_FILE ) . '/' );
		}
	}
	/*************************************
	 	Hook into actions and filters.
	**************************************/
	private function init_hooks() {
		add_action( 'admin_menu', array( $this, 'add_adv_help_page' ) );
	}
	/*************************************
	 	Add shortcode
	**************************************/
	private function init_shortcode() {
		add_shortcode('adv_manager', 'shortcode_parameter');
	}
	/*************************************************************
	  Include required core files used in admin and on the frontend.
	***************************************************************/
	public function includes() {
		//Adv manager - Admin
		include_once( ADV_ABSPATH . 'admin/admin-adv-manager.php' );
		include_once( ADV_ABSPATH . 'admin/admin-adv-help.php' );
		// shortcode
		include_once( ADV_ABSPATH . 'shortcodes/shortcode-param.php' );
	}

	/*
	 * Add Help page
	 */
	public function add_adv_help_page() {
		add_submenu_page( 'edit.php?post_type=advertise', 'Help', 'Help', 'manage_options', 'adv-help', 'help_page_callback' ); 
	}
	

}
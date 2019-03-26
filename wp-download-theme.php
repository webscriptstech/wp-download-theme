<?php
/**
 * Plugin Name: WP Download Theme
 * Version:     1.0.0
 * Plugin URI:  https://wordpress.org/plugins/wp-download-theme/
 * Author:      Web Scripts
 * Author URI:  http://webscripts.tech
 * Text Domain: wp-disable-search
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Description: Disable the WordPress Default search from front-end.
 *
 * Compatible with WordPress 4.6 through 4.9+.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Or visit: https://wordpress.org/plugins/wp-download-theme/
 *
 * @package WP_Disable_Search
 * @author  Web Scripts
 * @version 1.0.0
 */
defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'WP_Download_Theme' ) ) :

if ( ! defined( 'WP_DOWNLOAD_THEME_PATH' ) ) {
	define( 'WP_DOWNLOAD_THEME_PATH', dirname( __FILE__ ) );
}

if ( ! defined( 'WP_DOWNLOAD_THEME_URL' ) ) {
	define( 'WP_DOWNLOAD_THEME_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'WP_DOWNLOAD_THEME_PREFIX' ) ) {
	define( 'WP_DOWNLOAD_THEME_PREFIX', 'wpdt_' );
}


class WP_Download_Theme {

	/**
	 * Returns version of the plugin.
	 *
	 * @since 1.0
	 */
	public static function version() {
		return '1.0.0';
	}

	/**
	 * Prevent instantiation.
	 *
	 * @since 1.0
	 */
	private function __construct() {}

	/**
	 * Prevent unserializing an instance.
	 *
	 * @since 1.0
	 */
	private function __wakeup() {}

	/**
	 * Initializes the plugin.
	 */
	public static function init() {
		// Require a few needed files
		require_once( WP_DOWNLOAD_THEME_PATH . '/includes/class-wpdt.php' );
		add_action( 'plugins_loaded', array( __CLASS__, 'do_init' ) );
	}

	/**
	 * Performs actual initialization tasks.
	 *
	 * @since 1.5
	 */
	public static function do_init() {
		// Load textdomain.
		load_plugin_textdomain( 'wp-download-theme' );

	}

} // end WP_Download_Theme


WP_Download_Theme::init();

endif; // end if !class_exists()

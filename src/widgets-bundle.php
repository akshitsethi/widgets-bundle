<?php

/**
 * Plugin Name: Widgets Bundle
 * Description: The Widgets Bundle plugin allows you to add powerful collection of beautifully crafted widgets to your website.
 * Version:     @##VERSION##@
 * Runtime:     5.6+
 * Author:      akshitsethi
 * Text Domain: widgets-bundle
 * Domain Path: i18n
 * Author URI:  https://akshitsethi.com
 * License: 		GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace AkshitSethi\Plugins\WidgetsBundle {

	// Stop execution if the file is called directly.
	defined( 'ABSPATH' ) || exit;

	// Composer autoloder file.
	require_once __DIR__ . '/vendor/autoload.php';

	use AkshitSethi\Plugins\WidgetsBundle\Config;
	use AkshitSethi\Plugins\WidgetsBundle\Admin;


	/**
	 * Plugin class where all the action happens.
	 *
	 * @category   Plugins
	 * @package    AkshitSethi\Plugins\WidgetsBundle
	 * @since      2.0.0
	 */
	class WidgetsBundle {

		/**
		 * Class Constructor.
		 */
		public function __construct() {
			// Initialize admin
			new Admin();

			add_action( 'widgets_init', [ $this, 'register_widgets' ] );
		}


		public function register_widgets() {
			register_widget( __NAMESPACE__ . '\Widgets\Ads' );
			register_widget( __NAMESPACE__ . '\Widgets\Facebook' );
			register_widget( __NAMESPACE__ . '\Widgets\Instagram' );
			register_widget( __NAMESPACE__ . '\Widgets\Personal' );
			register_widget( __NAMESPACE__ . '\Widgets\Posts' );
			register_widget( __NAMESPACE__ . '\Widgets\Quote' );
			register_widget( __NAMESPACE__ . '\Widgets\Social' );
			register_widget( __NAMESPACE__ . '\Widgets\Subscribe' );
			register_widget( __NAMESPACE__ . '\Widgets\Twitter' );
		}


		/**
		 * Attached to the activation hook.
		 */
		public function activate() {
			// Add to `wp_options` table.
			update_option( Config::DB_OPTION, Config::DEFAULT_OPTIONS );
		}


		/**
		 * Attached to the de-activation hook.
		 */
		public function deactivate() {
			// Remove from `wp_options` table.
			delete_option( Config::DB_OPTION );
		}

	}

	// Initialize plugin.
	$widgets_bundle = new WidgetsBundle();

	/**
	 * Hooks for plugin activation & deactivation.
	 */
	register_activation_hook( __FILE__, [ $widgets_bundle, 'activate' ] );
	register_deactivation_hook( __FILE__, [ $widgets_bundle, 'deactivate' ] );

}

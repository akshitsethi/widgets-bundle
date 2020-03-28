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

namespace AkshitSethi\Plugins\WidgetsBundle;

// Stop execution if the file is called directly.
defined( 'ABSPATH' ) || exit;

// Composer autoloder file.
require_once __DIR__ . '/vendor/autoload.php';

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
		// Initialize front and admin
		new Front();
		new Admin();

		add_action( 'widgets_init', [ $this, 'register_widgets' ] );
	}


	public function register_widgets() {
		// Get option
		$widgets = get_option( Config::DB_OPTION );

		( $widgets['ads'] ) ? register_widget( __NAMESPACE__ . '\Widgets\Ads' ) : false;
		( $widgets['facebook'] ) ? register_widget( __NAMESPACE__ . '\Widgets\Facebook' ) : false;
		( $widgets['instagram'] ) ? register_widget( __NAMESPACE__ . '\Widgets\Instagram' ) : false;
		( $widgets['personal'] ) ? register_widget( __NAMESPACE__ . '\Widgets\Personal' ) : false;
		( $widgets['posts'] ) ? register_widget( __NAMESPACE__ . '\Widgets\Posts' ) : false;
		( $widgets['quote'] ) ? register_widget( __NAMESPACE__ . '\Widgets\Quote' ) : false;
		( $widgets['social'] ) ? register_widget( __NAMESPACE__ . '\Widgets\Social' ) : false;
		( $widgets['subscribe'] ) ? register_widget( __NAMESPACE__ . '\Widgets\Subscribe' ) : false;
		( $widgets['twitter'] ) ? register_widget( __NAMESPACE__ . '\Widgets\Twitter' ) : false;
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

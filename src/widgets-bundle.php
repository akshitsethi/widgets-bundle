<?php

/**
 * Plugin Name: Widgets Bundle
 * Description: The Widgets Bundle plugin allows you to add powerful collection of beautifully crafted widgets to your website.
 * Version:     2.0.5
 * Runtime:     5.6+
 * Author:      akshitsethi
 * Text Domain: widgets-bundle
 * Domain Path: i18n
 * Author URI:  https://akshitsethi.com
 * License:         GPLv3
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
		add_action( 'plugins_loaded', array( $this, 'init' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
	}


	/**
	 * Initialize plugin when all the plugins have been loaded.
	 *
	 * @since 2.0.0
	 */
	public function init() {
		// Initialize front and admin
		new Front();
		new Admin();

		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}


	 /**
	  * Register widgets conditionally if they are enabled.
	  *
	  * @since 2.0.0
	  */
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
	 * Loads textdomain for the plugin.
	 *
	 * @since 2.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( Config::PLUGIN_SLUG, false, Config::$plugin_path . 'i18n/' );
	}


	/**
	 * Attached to the activation hook.
	 */
	public function activate() {
		// Check for existing options in the database
		$options = get_option( Config::DB_OPTION );

		// Present? Overwrite the default options
		if ( $options ) {
			$options = array_merge( Config::DEFAULT_OPTIONS, $options );
		} else {
			$options = Config::DEFAULT_OPTIONS;
		}

		// Update `wp_options` table
		update_option( Config::DB_OPTION, $options );
	}


	/**
	 * Attached to the de-activation hook.
	 */
	public function deactivate() {
		/**
		 * @todo Keeping it here as it will be needed in future versions.
		 */
	}

}

// Initialize plugin.
$widgets_bundle = new WidgetsBundle();

/**
 * Hooks for plugin activation & deactivation.
 */
register_activation_hook( __FILE__, array( $widgets_bundle, 'activate' ) );
register_deactivation_hook( __FILE__, array( $widgets_bundle, 'deactivate' ) );

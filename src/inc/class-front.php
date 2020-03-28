<?php
/**
 * Frontend class for the plugin.
 *
 * @package AkshitSethi\Plugins\WidgetsBundle
 */

namespace AkshitSethi\Plugins\WidgetsBundle;

use AkshitSethi\Plugins\WidgetsBundle\Config;

/**
 * Frontend for the plugin.
 *
 * @package    AkshitSethi\Plugins\WidgetsBundle
 * @since      2.0.0
 */
class Front {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}


	/**
	 * Scripts for the frontend.
	 */
	public function scripts() {
		wp_enqueue_style( Config::SHORT_SLUG . '-bundle', Config::$plugin_url . 'assets/css/front.css', false, Config::VERSION );
	}

}

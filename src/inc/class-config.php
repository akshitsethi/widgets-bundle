<?php
/**
 * Configuration file for the plugin.
 */

namespace AkshitSethi\Plugins\WidgetsBundle;

/**
 * Set configuration options.
 *
 * @package AkshitSethi\Plugins\WidgetsBundle
 */
class Config {

	public static $plugin_url;
	public static $plugin_path;

	const PLUGIN_SLUG = 'widgets-bundle';
	const SHORT_SLUG  = 'widgetsbundle';
	const VERSION     = '2.0.5';
	const DB_OPTION   = 'as_' . self::SHORT_SLUG;
	const PREFIX      = self::SHORT_SLUG . '_';

	const DEFAULT_OPTIONS = array(
		'ads'       => true,
		'personal'  => true,
		'posts'     => true,
		'quote'     => true,
		'social'    => true,
		'subscribe' => true,
		'instagram' => true,
		'facebook'  => true,
		'twitter'   => true,
	);

	/**
	 * Class constructor.
	 */
	public function __construct() {
		self::$plugin_url  = plugin_dir_url( dirname( __FILE__ ) );
		self::$plugin_path = plugin_dir_path( dirname( __FILE__ ) );
	}


	/**
	 * Get plugin name.
	 *
	 * @since 1.0.0
	 */
	public static function get_plugin_name() {
		return esc_html__( 'Widgets Bundle', 'widgets-bundle' );
	}

}

new Config();

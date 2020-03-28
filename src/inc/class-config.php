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
	const SHORT_SLUG  = 'as-wb';
	const VERSION     = '@##VERSION##@';
	const DB_OPTION   = 'as_widgetsbundle';
	const PREFIX      = 'widgetsbundle_';

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

}

new Config();

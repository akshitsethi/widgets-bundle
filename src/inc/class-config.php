<?php

namespace AkshitSethi\Plugins\WidgetsBundle {

	/**
	 * Configuration options for the plugin.
	 *
	 * @package    AkshitSethi\Plugins\WidgetsBundle
	 * @since      2.0.0
	 */
	class Config {

		public static $plugin_url;
		public static $plugin_path;

		const PLUGIN_SLUG 		= 'widgets-bundle';
		const SHORT_SLUG 			= 'as-wb';
		const VERSION 				= '@##VERSION##@';
		const DB_OPTION      	= 'as_widgetsbundle';
		const PREFIX         	= 'widgetsbundle_';

		const DEFAULT_OPTIONS = [
			'ads' 			=> true,
			'personal' 	=> true,
			'posts' 		=> true,
			'quote' 		=> true,
			'social' 		=> true,
			'subscribe' => true,
			'instagram' => true,
			'facebook'  => true,
			'twitter' 	=> true
		];

		/**
		 * Class constructor.
		 */
		public function __construct() {
			self::$plugin_url 	= plugin_dir_url( dirname( __FILE__ ) );
			self::$plugin_path 	= plugin_dir_path( dirname( __FILE__ ) );
		}

	}

	new Config();

}

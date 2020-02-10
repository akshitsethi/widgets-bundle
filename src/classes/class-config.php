<?php

namespace AkshitSethi\Plugins\WidgetsBundle {

	/**
	 * Configuration options for the plugin.
	 *
	 * @package    AkshitSethi\Plugins\WidgetsBundle
	 * @since      2.0.0
	 */
	class Config {

		const DB_OPTION      	= 'as_widgetsbundle';
		const PREFIX         	= 'widgetsbundle_';
		const DEFAULT_OPTIONS = [
			'ads' 			=> true,
			'empty' 		=> true,
			'personal' 	=> true,
			'posts' 		=> true,
			'quote' 		=> true,
			'social' 		=> true,
			'subscribe' => true,
			'video' 		=> true,
			'instagram' => true,
			'facebook'  => true,
			'twitter' 	=> true
		];

	}

}

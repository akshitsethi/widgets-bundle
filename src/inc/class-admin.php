<?php

namespace AkshitSethi\Plugins\WidgetsBundle {

	use AkshitSethi\Plugins\WidgetsBundle\Config;

	/**
	 * Admin options for the plugin.
	 *
	 * @package    AkshitSethi\Plugins\WidgetsBundle
	 * @since      2.0.0
	 */
	class Admin {

		/**
		 * Class constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', [ $this, 'add_menu' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'widget_scripts' ] );

			add_filter( 'plugin_row_meta', [ $this, 'meta_links' ], 10, 2 );
		}


		/**
		 * Adds menu for the plugin.
		 */
		public function add_menu() {
			if ( is_admin() && current_user_can( 'manage_options' ) ) {
				$menu = add_options_page (
					esc_html__( 'Widgets Bundle', 'widgets-bundle' ),
					esc_html__( 'Widgets Bundle', 'widgets-bundle' ),
					'manage_options',
					Config::PREFIX . 'options',
					[ $this, 'settings' ]
				);
			
				// Loading JS conditionally.
				add_action( 'load-' . $menu, [ $this, 'load_scripts' ] );
			}	
		}


		/**
		 * Scripts for the plugin options page.
		 */
		public function admin_scripts() {
			wp_enqueue_style( Config::SHORT_SLUG . '-admin', Config::$plugin_url . 'assets/admin/css/admin.css', false, Config::VERSION );
			wp_enqueue_script( Config::SHORT_SLUG . '-admin', Config::$plugin_url . 'assets/admin/js/admin.js', [ 'jquery' ], Config::VERSION , true );
		}


		/**
		 * Adds action to load scripts via the scripts hook for admin.
		 */
		public function load_scripts() {
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
		}


		/**
		 * Scripts for the widgets page.
		 */
		public function widget_scripts() {
			$screen 		= get_current_screen();
			$localize 	= [
				'image_text' 					=> esc_html__( 'Choose Personal Image', 'widgets-bundle' ),
				'ad_text' 						=> esc_html__( 'Choose Advertisement', 'widgets-bundle' ),
				'save_text' 					=> esc_html__( 'Save', 'widgets-bundle' ),
				'remove_text' 				=> esc_html__( 'Remove', 'widgets-bundle' ),
				'image_preview_text' 	=> esc_html__( 'Image preview will show over here.', 'widgets-bundle' ),
				'ad_preview_text' 		=> esc_html__( 'Ad preview will show over here.', 'widgets-bundle' )
			];
			
			wp_enqueue_style( Config::SHORT_SLUG . '-widgets', Config::$plugin_url . 'assets/admin/css/widgets.css', false, Config::VERSION );
			wp_register_script( Config::SHORT_SLUG . '-widgets', Config::$plugin_url . 'assets/admin/js/widgets.js', [ 'jquery' ], Config::VERSION, false );

			wp_localize_script( Config::SHORT_SLUG . '-widgets', Config::PREFIX . 'js', $localize );

			// Scripts
			wp_enqueue_script( Config::SHORT_SLUG . '-widgets' );
			
			if ( 'widgets' == $screen->id ) {
				// Media uploader
				wp_enqueue_media();
			}	
		}


		/**
		 * Adds custom links to the meta on the plugins page.
		 * 
		 * @param array  $links Array of links for the plugins
		 * @param string $file  Name of the main plugin file
		 * 
		 * @return array
		 */
		public function meta_links( $links, $file ) {
			if ( strpos( $file, 'widgets-bundle.php' ) !== FALSE ) {
				$new_links = [
					'<a href="https://www.facebook.com/akshitsethi" target="_blank">' . esc_html__( 'Facebook', 'widgets-bundle' ) . '</a>',
					'<a href="https://twitter.com/akshitsethi" target="_blank">' . esc_html__( 'Twitter', 'widgets-bundle' ) . '</a>'
				];

				$links = array_merge( $links, $new_links );
			}

			return $links;
		}

		/**
		 * Displays settings page for the plugin.
		 */
		public function settings() {
			require_once Config::$plugin_path . 'inc/admin/views/settings.php';
		}

	}

}

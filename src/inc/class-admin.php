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
			add_action( 'wp_ajax_' . Config::PREFIX . 'support', [ $this, 'support_ticket' ] );
			add_action( 'wp_ajax_' . Config::PREFIX . 'options', [ $this, 'save_options' ] );

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

			// Localize and enqueue script
			wp_register_script( Config::SHORT_SLUG . '-admin', Config::$plugin_url . 'assets/admin/js/admin.js', [ 'jquery' ], Config::VERSION , true );

			$localize = [
				'prefix' 				=> Config::PREFIX,
				'save_text' 		=> esc_html__( 'Save Changes', 'widgets-bundle' ),
				'support_text' 	=> esc_html__( 'Ask for Support', 'widgets-bundle' )
			];

			wp_enqueue_script( Config::SHORT_SLUG . '-admin' );
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
		 * Processes plugin options via an AJAX call.
		 */
		public function save_options() {
			// Storing response in an array
			$response = [
				'code' 			=> 'success',
				'response' 	=> esc_html__( 'Options have been updated successfully.', 'widgets-bundle' )
			];

			// Filter and sanitize
			$options['ads'] 			= isset( $_POST['as_wb_ads'] ) 				? true : false;
			$options['personal'] 	= isset( $_POST['as_wb_personal'] ) 	? true : false;
			$options['posts'] 		= isset( $_POST['as_wb_posts'] ) 			? true : false;
			$options['quote'] 		= isset( $_POST['as_wb_quote'] ) 			? true : false;
			$options['social'] 		= isset( $_POST['as_wb_social'] ) 		? true : false;
			$options['subscribe'] = isset( $_POST['as_wb_subscribe'] ) 	? true : false;
			$options['instagram'] = isset( $_POST['as_wb_instagram'] ) 	? true : false;
			$options['facebook'] 	= isset( $_POST['as_wb_facebook'] ) 	? true : false;
			$options['twitter'] 	= isset( $_POST['as_wb_twitter'] ) 		? true : false;

			// Update options
			update_option( Config::DB_OPTION, $options );

			// Headers for JSON format
			header( "Content-Type: application/json" );
			echo json_encode( $response );

			// Exit
			// For AJAX functions
			exit();
		}


		/**
		 * Creates support ticket via the options panel.
		 */
		public function support_ticket() {
			// Storing response in an array
			$response = [
				'code' 			=> 'error',
				'response' 	=> esc_html__( 'Please fill in both the fields to create your support ticket.', 'widgets-bundle' )
			];

			// Filter and sanitize
			if ( ! empty( $_POST['as_support_email'] ) && ! empty( $_POST['as_support_issue'] ) ) {
				$admin_email 	= sanitize_text_field( $_POST['as_support_email'] );
				$issue 				= htmlentities( $_POST['as_support_issue'] );
				$subject 			= '[Widgets Bundle v' . Config::VERSION . '] by ' . $admin_email;
				$body 				= "Email: $admin_email \r\nIssue: $issue";
				$headers 			= 'From: ' . $admin_email . "\r\n" . 'Reply-To: ' . $admin_email;

				// Send email
				if ( wp_mail( 'akshitsethi@gmail.com', $subject, $body, $headers ) ) {
					// Success
					$response = [
						'code' 			=> 'success',
						'response' 	=> esc_html__( 'I have received your support ticket and will get back to you shortly!', 'widgets-bundle' )
					];
				} else {
					// Failure
					$response = [
						'code' 			=> 'error',
						'response' 	=> esc_html__( 'There was an error creating the support ticket. You can try again later or send me an email directly at akshitsethi@gmail.com', 'widgets-bundle' )
					];
				}
			}

			// Headers for JSON format
			header( "Content-Type: application/json" );
			echo json_encode( $response );

			// Exit
			// For AJAX functions
			exit();
		}


		/**
		 * Displays settings page for the plugin.
		 */
		public function settings() {
			require_once Config::$plugin_path . 'inc/admin/views/settings.php';
		}

	}

}

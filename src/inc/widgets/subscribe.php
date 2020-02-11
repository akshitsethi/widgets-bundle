<?php

/**
 * Plugin Name: Subscribe Widget
 * Description: Widget for subscription form utilising the MailChimp API.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets {

	use WP_Widget;

	class Subscribe extends WP_Widget {

		public function __construct() {
			parent::__construct( 'as_wb_subscribe', esc_html__( 'Subscribe', 'widgets-bundle' ), array(
				'classname'   => 'as_wb_subscribe',
				'description' => esc_html__( 'Widget for subscription form utilising the MailChimp API.', 'widgets-bundle' )
			) );
		}


		/**
		 * Output the HTML.
		 *
		 * @access public
		 *
		 * @param array $args     An array of standard parameters for widgets in this theme.
		 * @param array $instance An array of settings for this widget instance.
		 * @return void Echoes its output.
		 * -------------------------------------------------
		 */

		public function widget( $args, $instance ) {

			$instance 	= wp_parse_args( (array) $instance, self::defaults() );
			$title 		= apply_filters( 'widget_title', $instance['title'] );
			$text 		= $instance['text'];
			$api_key 	= $instance['api_key'];
			$list_id 	= $instance['list_id'];

			// Submission Checks
			if ( ! empty( $api_key ) && ! empty( $list_id ) ) {
				if ( isset( $_POST['as-subscribe-email'] ) ) {
					// Looks Good
					// Start Processing
					$email =  sanitize_text_field( $_POST['as-subscribe-email'] );

					if ( '' === $email ) {
						$response['code'] 	= 'error';
						$response['text'] 	= esc_html__( 'Please provide your email address.', 'widgets-bundle' );
					} else {
						$email = filter_var( strtolower( trim( $email ) ), FILTER_SANITIZE_EMAIL );

						if ( strpos( $email, '@' ) ) {
							require AS_WB_PATH . 'framework/public/include/classes/class-mailchimp.php';

							// API Call
							$mailchimp 	= new As_Wb_Mailchimp( $api_key );
							$connect 	= $mailchimp->call( 'lists/subscribe', array(
								'apikey'		=> $api_key,
								'id'            => $list_id,
								'email'         => array( 'email' => $email ),
								'double_optin'  => TRUE,
								'send_welcome'  => TRUE
							) );

							// Collect Response
							if ( isset( $connect['code'] ) && 'ASERR' === $connect['code'] ) {
								$response['code'] 	= 'error';
								$response['text'] 	= $connect['message'];
							} elseif ( isset( $connect['code'] ) && 214 !== $connect['code'] ) {
								$response['code'] 	= 'error';
								$response['text'] 	= esc_html__( 'Oops! Something went wrong.', 'widgets-bundle' );
							} elseif ( isset( $connect['code'] ) && 214 === $connect['code'] ) {
								$response['code'] 	= 'success';
								$response['text'] 	= esc_html__( 'You are already subscribed!', 'widgets-bundle' );
							} else {
								$response['code'] 	= 'success';
								$response['text'] 	= esc_html__( 'Thank you! We\'ll be in touch!', 'widgets-bundle' );
							}
						} else {
							$response['code'] 	= 'error';
							$response['text'] 	= esc_html__( 'Please provide a valid email address.', 'widgets-bundle' );
						}
					}
				}
			}

			echo $args['before_widget'];

			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			echo '<div class="as-wb-subscribe">';

			// Text
			if ( ! empty( $text ) ) {
				echo '<p>';
				echo wp_kses( $text, array(
						'a' 		=> array(
							'href' 	=> array(),
							'title' => array()
						),
						'br' 		=> array(),
						'em' 		=> array(),
						'strong' 	=> array()
					)
				);
				echo '</p>';
			}

			// Form
			echo '<form method="POST">';

			// Show Response
			if ( isset( $response ) ) {
				echo '<div class="as-wb-response as-wb-response-' . $response['code'] . '">' . $response['text'] . '</div><!-- .as-wb-subscribe-response -->';
			}

			echo '<div class="as-wb-form-group">';
			echo '<input type="text" name="as-subscribe-email" class="as-wb-form-control" placeholder="' . esc_html__( 'Enter your email address..', 'widgets-bundle' ) . '" />';
			echo '</div><!-- .as-wb-form-group -->';

			echo '<div class="as-wb-subscribe-button">';
			echo '<input type="submit" value="' . esc_html__( 'Subscribe', 'widgets-bundle' ) . '">';
			echo '</div><!-- .as-wb-subscribe-button -->';
			echo '</form>';

			echo '</div><!-- .as-wb-subscribe -->';
			echo $args['after_widget'];

		}


		/**
		 * Deal with the settings when they are saved by the admin.
		 * Here is where any validation should happen.
		 *
		 * @param array $new_instance New widget instance.
		 * @param array $instance     Original widget instance.
		 * @return array Updated widget instance.
		 * -------------------------------------------------
		 */

		function update( $new_instance, $instance ) {

			$new_instance 		= wp_parse_args( (array) $new_instance, self::defaults() );
			$instance['title'] 	= sanitize_text_field( $new_instance['title'] );
			$instance['text'] 	= wp_kses( stripslashes( $new_instance['text'] ), array(
					'a' 		=> array(
						'href' 	=> array(),
						'title' => array()
					),
					'br' 		=> array(),
					'em' 		=> array(),
					'strong' 	=> array()
				)
			);
			$instance['api_key'] = sanitize_text_field( $new_instance['api_key'] );
			$instance['list_id'] = sanitize_text_field( $new_instance['list_id'] );

			return $instance;

		}


		/**
		 * Widget Form.
		 *
		 * @param array $instance
		 * @return void
		 * -------------------------------------------------
		 */

		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, self::defaults() );

		?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'widgets-bundle' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text', 'widgets-bundle' ); ?></label>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_attr( $instance['text'] ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>"><?php esc_html_e( 'API Key', 'widgets-bundle' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'api_key' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['api_key'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'list_id' ) ); ?>"><?php esc_html_e( 'List ID', 'widgets-bundle' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_id' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['list_id'] ); ?>" />
			</p>

		<?php

		}


		/**
		 * Default Options.
		 * @access private
		 * -------------------------------------------------
		 */

		private static function defaults() {

			$defaults = array(
				'title' 	=> esc_html__( 'Subscribe', 'widgets-bundle' ),
				'text' 		=> esc_html__( 'We will reach your mailbox twice a month only. Don\'t worry, we hate spam too!', 'widgets-bundle' ),
				'api_key' 	=> '',
				'list_id' 	=> ''
			);

			return $defaults;

		}

	}

}

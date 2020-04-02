<?php

/**
 * Plugin Name: Subscribe Widget
 * Description: Widget for subscription form utilising the MailChimp API.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets;

use Exception;
use WP_Widget;
use AkshitSethi\Plugins\WidgetsBundle\Config;
use DrewM\MailChimp\MailChimp;

class Subscribe extends WP_Widget {

	public function __construct() {
		parent::__construct(
			Config::PREFIX . 'subscribe',
			esc_html__( 'Subscribe', 'widgets-bundle' ),
			array(
				'classname'   => Config::PREFIX . 'subscribe',
				'description' => esc_html__( 'Widget for subscription form utilising the MailChimp API.', 'widgets-bundle' ),
			)
		);
	}


	/**
	 * Output the HTML.
	 *
	 * @access public
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme.
	 * @param array $instance An array of settings for this widget instance.
	 * @return void Echoes its output.
	 */
	public function widget( $args, $instance ) {
		$instance        = wp_parse_args( (array) $instance, self::defaults() );
		$title           = apply_filters( 'widget_title', $instance['title'] );
		$text            = $instance['text'];
		$api_key         = $instance['api_key'];
		$list_id         = $instance['list_id'];
		$success_message = $instance['success_message'];

		// Submission check
		if ( ! empty( $api_key ) && ! empty( $list_id ) ) {
			if ( isset( $_POST[ Config::PREFIX . 'subscribe_email' ] ) ) {
				// Default response
				$response = array(
					'code' => 'error',
					'text' => esc_html__( 'There was an error processing your request.', 'widgets-bundle' ),
				);

				// Process information
				$email = sanitize_text_field( $_POST[ Config::PREFIX . 'subscribe_email' ] );

				if ( empty( $email ) ) {
					$response['text'] = esc_html__( 'Please provide your email address.', 'widgets-bundle' );
				} else {
					$email = filter_var( strtolower( trim( $email ) ), FILTER_SANITIZE_EMAIL );

					if ( $email ) {
						try {
							// API call
							$mailchimp = new MailChimp( sanitize_text_field( $api_key ) );

							// Send data via POST
							$connect = $mailchimp->post(
								'lists/' . sanitize_text_field( $list_id ) . '/members',
								array(
									'email_address' => $email,
									'status'        => 'subscribed',
								)
							);

							// Show the response
							if ( $mailchimp->success() ) {
								$response['code'] = 'success';

								// Show the success message if not empty
								if ( ! empty( $success_message ) ) {
									$response['text'] = esc_html( $success_message );
								} else {
									$response['text'] = esc_html__( 'Thank you! We\'ll be in touch!', 'widgets-bundle' );
								}
							} else {
								if ( 400 === $mailchimp->getLastResponse()['headers']['http_code'] ) {
									$response['code'] = 'success';
									$response['text'] = esc_html__( 'You are already subscribed. We will reach you shortly.', 'widgets-bundle' );
								} else {
									$response['text'] = esc_html( $mailchimp->getLastError() );
								}
							}
						} catch ( Exception $e ) {
							$response['text'] = $e->getMessage();
						}
					} else {
						$response['text'] = esc_html__( 'Please provide a valid email address.', 'widgets-bundle' );
					}
				}
			}
		}

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// Show the widget only if the API key and List ID are provided
		echo '<div class="as-wb-subscribe">';

		if ( ! empty( $api_key ) && ! empty( $list_id ) ) {
			// Widget code
			if ( ! empty( $text ) ) {
				echo '<p>';
				echo wp_kses(
					$text,
					array(
						'a'      => array(
							'href'  => array(),
							'title' => array(),
						),
						'br'     => array(),
						'em'     => array(),
						'strong' => array(),
					)
				);
				echo '</p>';
			}

			// Form
			echo '<form method="POST">';

			// Response
			if ( isset( $response ) ) {
				echo '<div class="as-wb-subscribe--response as-wb-subscribe--response-' . $response['code'] . '">' . $response['text'] . '</div><!-- .as-wb-subscribe--response -->';
			}

			echo '<div class="as-wb-subscribe--form-group">';
			echo '<input type="text" name="' . Config::PREFIX . 'subscribe_email" class="as-wb-subscribe--form-control" placeholder="' . esc_html__( 'Enter your email address..', 'widgets-bundle' ) . '" />';
			echo '</div><!-- .as-wb-subscribe--form-group -->';

			echo '<div class="as-wb-subscribe--button">';
			echo '<input type="submit" value="' . esc_html__( 'Subscribe', 'widgets-bundle' ) . '">';
			echo '</div><!-- .as-wb-subscribe--button -->';
			echo '</form>';

		} else {
			echo '<p>' . esc_html__( 'Please provide your API key and List ID for this widget to work properly.', 'widgets-bundle' ) . '</p>';
		}

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
	 */
	public function update( $new_instance, $instance ) {
		$new_instance                = wp_parse_args( (array) $new_instance, self::defaults() );
		$instance['title']           = sanitize_text_field( $new_instance['title'] );
		$instance['text']            = wp_kses(
			stripslashes(
				$new_instance['text']
			),
			array(
				'a'      => array(
					'href'  => array(),
					'title' => array(),
				),
				'br'     => array(),
				'em'     => array(),
				'strong' => array(),
			)
		);
		$instance['api_key']         = sanitize_text_field( $new_instance['api_key'] );
		$instance['list_id']         = sanitize_text_field( $new_instance['list_id'] );
		$instance['success_message'] = sanitize_text_field( $new_instance['success_message'] );

		return $instance;
	}


	/**
	 * Widget form.
	 *
	 * @param array $instance
	 * @return void
	 */
	public function form( $instance ) {
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

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'success_message' ) ); ?>"><?php esc_html_e( 'Success Message', 'widgets-bundle' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'success_message' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'success_message' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['success_message'] ); ?>" />
		</p>

		<?php
	}


	/**
	 * Default options.
	 *
	 * @access private
	 */
	private static function defaults() {
		$defaults = array(
			'title'           => esc_html__( 'Subscribe', 'widgets-bundle' ),
			'text'            => esc_html__( 'We will reach your mailbox only twice a month. Don\'t worry, we hate spam too!', 'widgets-bundle' ),
			'api_key'         => '',
			'list_id'         => '',
			'success_message' => esc_html__( 'Thank you! We\'ll be in touch!', 'widgets-bundle' ),
		);

		return $defaults;
	}

}

<?php

/**
 * Plugin Name: Personal Widget
 * Description: Widget for showing personal image along with short bio.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets;

use WP_Widget;
use AkshitSethi\Plugins\WidgetsBundle\Config;

class Personal extends WP_Widget {

	public function __construct() {
		parent::__construct(
			Config::PREFIX . 'personal',
			esc_html__( 'Personal', 'widgets-bundle' ),
			array(
				'classname'   => Config::PREFIX . 'personal',
				'description' => esc_html__( 'Widget for showing personal image along with a short bio.', 'widgets-bundle' ),
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
		$instance = wp_parse_args( (array) $instance, self::defaults() );
		$title    = apply_filters( 'widget_title', $instance['title'] );
		$url      = $instance['url'];
		$bio      = $instance['bio'];

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="as-wb-personal">';

		// Photo
		if ( ! empty( $url ) ) {
			echo '<div class="as-wb-personal--image">';
			echo '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $title ) . '" />';
			echo '</div><!-- .as-wb-personal--image -->';
		}

		// Bio
		if ( ! empty( $bio ) ) {
			echo '<p>';
			echo wp_kses(
				$bio,
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

		echo '</div><!-- .as-wb-personal -->';
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
		$new_instance      = wp_parse_args( (array) $new_instance, self::defaults() );
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['url']   = sanitize_text_field( $new_instance['url'] );
		$instance['bio']   = wp_kses(
			stripslashes( $new_instance['bio'] ),
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

		<div class="as-wb-upload">
			<span class="as-wb-preview">
				<?php if ( ! empty( $instance['url'] ) ) : ?>
					<img src="<?php echo esc_url( $instance['url'] ); ?>" />
				<?php else : ?>
					<?php esc_html_e( 'Image preview will show over here.', 'widgets-bundle' ); ?>
				<?php endif; ?>
			</span>

			<input class="as-wb-url" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="hidden" value="<?php echo esc_attr( $instance['url'] ); ?>" />
			<button class="button" id="as-wb-btn"><?php esc_html_e( 'Select Image', 'widgets-bundle' ); ?></button>

			<span class="as-wb-append">
				<?php if ( ! empty( $instance['url'] ) ) : ?>
					<a href="javascript:;" id="as-wb-remove"><?php esc_html_e( 'Remove', 'widgets-bundle' ); ?></a>
				<?php endif; ?>
			</span>
		</div><!-- .as-wb-upload -->

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'bio' ) ); ?>"><?php esc_html_e( 'Bio', 'widgets-bundle' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'bio' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bio' ) ); ?>"><?php echo esc_textarea( $instance['bio'] ); ?></textarea>
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
			'title' => esc_html__( 'About Me', 'widgets-bundle' ),
			'url'   => '',
			'bio'   => '',
		);

		return $defaults;
	}

}

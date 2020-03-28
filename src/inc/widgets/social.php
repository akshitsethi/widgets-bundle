<?php

/**
 * Plugin Name: Social Widget
 * Description: Widget for showing Social Media profile links with icons.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets;

use WP_Widget;
use AkshitSethi\Plugins\WidgetsBundle\Config;

class Social extends WP_Widget {

	public function __construct() {
		parent::__construct(
			Config::PREFIX . 'social',
			esc_html__( 'Social', 'widgets-bundle' ),
			array(
				'classname'   => Config::PREFIX . 'social',
				'description' => esc_html__( 'Widget for showing Social Media profile links with icons.', 'widgets-bundle' ),
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
		$instance  = wp_parse_args( (array) $instance, self::defaults() );
		$title     = apply_filters( 'widget_title', $instance['title'] );
		$text      = $instance['text'];
		$target    = $instance['target'];
		$facebook  = $instance['facebook'];
		$twitter   = $instance['twitter'];
		$google    = $instance['google'];
		$instagram = $instance['instagram'];
		$pinterest = $instance['pinterest'];
		$linkedin  = $instance['linkedin'];
		$youtube   = $instance['youtube'];
		$flickr    = $instance['flickr'];
		$github    = $instance['github'];
		$dribbble  = $instance['dribbble'];

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="as-wb-social">';

		// Text
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

		echo '<div class="as-wb-social--icons">';

		// Facebook
		if ( ! empty( $facebook ) ) {
			echo '<a href="' . esc_url( $facebook ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-facebook"></i></a>';
		}

		// Twitter
		if ( ! empty( $twitter ) ) {
			echo '<a href="' . esc_url( $twitter ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-twitter"></i></a>';
		}

		// Google+
		if ( ! empty( $google ) ) {
			echo '<a href="' . esc_url( $google ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-gplus"></i></a>';
		}

		// Instagram
		if ( ! empty( $instagram ) ) {
			echo '<a href="' . esc_url( $instagram ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-instagram"></i></a>';
		}

		// Pinterest
		if ( ! empty( $pinterest ) ) {
			echo '<a href="' . esc_url( $pinterest ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-pinterest"></i></a>';
		}

		// LinkedIn
		if ( ! empty( $linkedin ) ) {
			echo '<a href="' . esc_url( $linkedin ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-linkedin"></i></a>';
		}

		// YouTube
		if ( ! empty( $youtube ) ) {
			echo '<a href="' . esc_url( $youtube ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-youtube"></i></a>';
		}

		// Flickr
		if ( ! empty( $flickr ) ) {
			echo '<a href="' . esc_url( $flickr ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-flickr"></i></a>';
		}

		// GitHub
		if ( ! empty( $github ) ) {
			echo '<a href="' . esc_url( $github ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-github"></i></a>';
		}

		// Dribbble
		if ( ! empty( $dribbble ) ) {
			echo '<a href="' . esc_url( $dribbble ) . '" target="' . esc_attr( $target ) . '"><i class="icon icon-dribbble"></i></a>';
		}

		echo '</div><!-- .as-wb-social--icons -->';
		echo '</div><!-- .as-wb-social -->';
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
		$new_instance          = wp_parse_args( (array) $new_instance, self::defaults() );
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['text']      = wp_kses(
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
		$instance['target']    = sanitize_text_field( $new_instance['target'] );
		$instance['facebook']  = sanitize_text_field( esc_url( $new_instance['facebook'] ) );
		$instance['twitter']   = sanitize_text_field( esc_url( $new_instance['twitter'] ) );
		$instance['google']    = sanitize_text_field( esc_url( $new_instance['google'] ) );
		$instance['instagram'] = sanitize_text_field( esc_url( $new_instance['instagram'] ) );
		$instance['pinterest'] = sanitize_text_field( esc_url( $new_instance['pinterest'] ) );
		$instance['linkedin']  = sanitize_text_field( esc_url( $new_instance['linkedin'] ) );
		$instance['flickr']    = sanitize_text_field( esc_url( $new_instance['flickr'] ) );
		$instance['youtube']   = sanitize_text_field( esc_url( $new_instance['youtube'] ) );
		$instance['github']    = sanitize_text_field( esc_url( $new_instance['github'] ) );
		$instance['dribbble']  = sanitize_text_field( esc_url( $new_instance['dribbble'] ) );

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

		// Default options
		$defaults = self::defaults();

		// Fields
		foreach ( $defaults as $key => $value ) {
			echo '<p>';
			echo '<label for="' . esc_attr( $this->get_field_id( $key ) ) . '">' . sprintf( esc_html_x( '%1$s', 'title', 'widgets-bundle' ), ucfirst( $key ) ) . '</label>';

			if ( 'text' == $key ) {
				echo '<textarea class="widefat" id="' . esc_attr( $this->get_field_id( $key ) ) . '" name="' . esc_attr( $this->get_field_name( $key ) ) . '">' . esc_textarea( $instance[ $key ] ) . '</textarea>';
			} elseif ( 'target' == $key ) {
				echo '<select class="widefat" id="' . esc_attr( $this->get_field_id( 'target' ) ) . '" name="' . esc_attr( $this->get_field_name( 'target' ) ) . '">';
				echo '<option value="' . esc_attr__( '_self', 'widgets-bundle' ) . '"' . selected( __( '_self', 'widgets-bundle' ), $instance['target'], false ) . '>' . esc_attr__( 'Current Window', 'widgets-bundle' ) . '</option>';
				echo '<option value="' . esc_attr__( '_blank', 'widgets-bundle' ) . '"' . selected( __( '_blank', 'widgets-bundle' ), $instance['target'], false ) . '>' . esc_attr__( 'New Window', 'widgets-bundle' ) . '</option>';
				echo '</select>';
			} else {
				echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( $key ) ) . '" name="' . esc_attr( $this->get_field_name( $key ) ) . '" type="text" value="' . esc_attr( $instance[ $key ] ) . '" />';
			}

			echo '</p>';
		}
	}


	/**
	 * Default options.
	 *
	 * @access private
	 */
	private static function defaults() {
		$defaults = array(
			'title'     => '',
			'text'      => '',
			'target'    => '',
			'facebook'  => '',
			'twitter'   => '',
			'google'    => '',
			'instagram' => '',
			'pinterest' => '',
			'linkedin'  => '',
			'youtube'   => '',
			'flickr'    => '',
			'github'    => '',
			'dribbble'  => '',
		);

		return $defaults;
	}

}

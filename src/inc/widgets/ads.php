<?php

/**
 * Plugin Name: Ads Widget
 * Description: Widget for showing ads in 125 x 125 px format.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets;

use WP_Widget;
use AkshitSethi\Plugins\WidgetsBundle\Config;

class Ads extends WP_Widget {

	public function __construct() {
		parent::__construct(
			Config::PREFIX . 'ads',
			esc_html__( 'Ads', 'widgets-bundle' ),
			array(
				'classname'   => Config::PREFIX . 'ads',
				'description' => esc_html__( 'Widget for showing ads in 125 x 125 px format.', 'widgets-bundle' ),
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
		$image    = $instance['image'];
		$link     = $instance['link'];
		$target   = $instance['target'];
		$text     = $instance['text'];

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="as-wb-ads">';

		// Photo & link.
		if ( ! empty( $image ) && ! empty( $link ) && ! empty( $target ) ) {
			echo '<div class="as-wb-ads--image">';
			echo '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '">';
			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $title ) . '" />';
			echo '</a>';
			echo '</div><!-- .as-wb-ads--image -->';
		}

		// Text.
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

		echo '</div><!-- .as-wb-ads -->';
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
		$new_instance       = wp_parse_args( (array) $new_instance, self::defaults() );
		$instance['title']  = sanitize_text_field( $new_instance['title'] );
		$instance['image']  = sanitize_text_field( $new_instance['image'] );
		$instance['link']   = sanitize_text_field( esc_url( $new_instance['link'] ) );
		$instance['target'] = sanitize_text_field( $new_instance['target'] );
		$instance['text']   = wp_kses(
			stripslashes( $new_instance['text'] ),
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
				<?php if ( ! empty( $instance['image'] ) ) : ?>
					<img src="<?php echo esc_url( $instance['image'] ); ?>" />
				<?php else : ?>
					<?php esc_html_e( 'Ad preview will show over here.', 'widgets-bundle' ); ?>
				<?php endif; ?>
			</span>

			<input class="as-wb-url" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="hidden" value="<?php echo esc_attr( $instance['image'] ); ?>" />
			<button class="button" id="as-wb-btn"><?php esc_html_e( 'Select Image', 'widgets-bundle' ); ?></button>

			<span class="as-wb-append">
				<?php if ( ! empty( $instance['image'] ) ) : ?>
					<a href="javascript:;" id="as-wb-remove"><?php esc_html_e( 'Remove', 'widgets-bundle' ); ?></a>
				<?php endif; ?>
			</span>
		</div>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Link', 'widgets-bundle' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['link'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Target', 'widgets-bundle' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>">
				<option value="<?php esc_attr_e( '_self', 'widgets-bundle' ); ?>"<?php selected( '_self', $instance['target'] ); ?>><?php esc_html_e( 'Self', 'widgets-bundle' ); ?></option>
				<option value="<?php esc_attr_e( '_blank', 'widgets-bundle' ); ?>"<?php selected( '_blank', $instance['target'] ); ?>><?php esc_html_e( 'New Window', 'widgets-bundle' ); ?></option>
				<option value="<?php esc_attr_e( '_parent', 'widgets-bundle' ); ?>"<?php selected( '_parent', $instance['target'] ); ?>><?php esc_html_e( 'Parent', 'widgets-bundle' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text', 'widgets-bundle' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
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
			'title'  => esc_html__( 'Sponsored', 'widgets-bundle' ),
			'image'  => '',
			'link'   => '',
			'target' => '_blank',
			'text'   => '',
		);

		return $defaults;
	}

}

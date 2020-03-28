<?php

/**
 * Plugin Name: Quote Widget
 * Description: Widget for Quotes.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets;

use WP_Widget;
use AkshitSethi\Plugins\WidgetsBundle\Config;

class Quote extends WP_Widget {

	public function __construct() {
		parent::__construct(
			Config::PREFIX . 'quote',
			esc_html__( 'Quote', 'widgets-bundle' ),
			array(
				'classname'   => Config::PREFIX . 'quote',
				'description' => esc_html__( 'Widget that displays your Quotes.', 'widgets-bundle' ),
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
		$quote    = $instance['quote'];
		$citation = $instance['citation'];

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="as-wb-quote">';

		// Quote
		if ( ! empty( $quote ) ) {
			echo '<blockquote>';
			echo '<p>' . esc_html( $quote ) . '</p>';

			// Citation
			if ( ! empty( $citation ) ) {
				echo '<cite>' . esc_html( $citation ) . '</cite>';
			}

			echo '</blockquote>';
		}

		echo '</div><!-- .as-wb-quote -->';
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
		$new_instance         = wp_parse_args( (array) $new_instance, self::defaults() );
		$instance['title']    = sanitize_text_field( $new_instance['title'] );
		$instance['quote']    = sanitize_text_field( $new_instance['quote'] );
		$instance['citation'] = sanitize_text_field( $new_instance['citation'] );

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
			<label for="<?php echo esc_attr( $this->get_field_id( 'quote' ) ); ?>"><?php esc_html_e( 'Quote', 'widgets-bundle' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'quote' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'quote' ) ); ?>"><?php echo esc_textarea( $instance['quote'] ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'citation' ) ); ?>"><?php esc_html_e( 'Citation', 'widgets-bundle' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'citation' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'citation' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['citation'] ); ?>" />
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
			'title'    => esc_html__( 'Today\'s Quote', 'widgets-bundle' ),
			'quote'    => '',
			'citation' => '',
		);

		return $defaults;
	}

}

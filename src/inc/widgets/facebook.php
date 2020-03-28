<?php

/**
 * Plugin Name: Facebook Widget
 * Description: Widget for Facebook page feed.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets;

use WP_Widget;
use AkshitSethi\Plugins\WidgetsBundle\Config;

class Facebook extends WP_Widget {

	public function __construct() {
		parent::__construct(
			Config::PREFIX . 'facebook',
			esc_html__( 'Facebook', 'widgets-bundle' ),
			array(
				'classname'   => Config::PREFIX . 'facebook',
				'description' => esc_html__( 'Widget that displays your Facebook page feed.', 'widgets-bundle' ),
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
		$app_id          = $instance['app_id'];
		$url             = $instance['url'];
		$width           = $instance['width'];
		$height          = $instance['height'];
		$small_header    = ! empty( $instance['small_header'] ) ? 'true' : 'false';
		$container_width = ! empty( $instance['container_width'] ) ? 'true' : 'false';
		$hide_cover      = ! empty( $instance['hide_cover'] ) ? 'true' : 'false';
		$show_facepile   = ! empty( $instance['show_facepile'] ) ? 'true' : 'false';
		$show_posts      = ! empty( $instance['show_posts'] ) ? 'true' : 'false';

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// Widget code
		echo '<div class="as-wb-facebook">';
		echo '<iframe src="https://www.facebook.com/plugins/page.php?href=' . urlencode( $url ) . '&tabs=timeline&width=' . $width . '&height=' . $height . '&small_header=' . $small_header . '&adapt_container_width=' . $container_width . '&hide_cover=' . $hide_cover . '&show_facepile=' . $show_facepile . '&appId=' . $app_id . '" width="' . $width . '" height="' . $height . '" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>';
		echo '</div><!-- .as-wb-facebook -->';

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
		$instance['app_id']          = sanitize_text_field( $new_instance['app_id'] );
		$instance['url']             = sanitize_text_field( $new_instance['url'] );
		$instance['width']           = sanitize_text_field( $new_instance['width'] );
		$instance['height']          = sanitize_text_field( $new_instance['height'] );
		$instance['small_header']    = ! empty( $new_instance['small_header'] ) ? 1 : 0;
		$instance['container_width'] = ! empty( $new_instance['container_width'] ) ? 1 : 0;
		$instance['hide_cover']      = ! empty( $new_instance['hide_cover'] ) ? 1 : 0;
		$instance['show_facepile']   = ! empty( $new_instance['show_facepile'] ) ? 1 : 0;
		$instance['show_posts']      = ! empty( $new_instance['show_posts'] ) ? 1 : 0;

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
			<label for="<?php echo esc_attr( $this->get_field_id( 'app_id' ) ); ?>"><?php esc_html_e( 'Facebook Application ID', 'widgets-bundle' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'app_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'app_id' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['app_id'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_html_e( 'Facebook Page URL', 'widgets-bundle' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['url'] ); ?>" />
		</p>

		<p>
			<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_posts' ) ); ?>" type="checkbox" <?php checked( $instance['show_posts'], 1 ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_posts' ) ); ?>"><?php esc_html_e( 'Show Posts from Page Timeline', 'widgets-bundle' ); ?></label>
		</p>

		<p>
			<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_cover' ) ); ?>" type="checkbox" <?php checked( $instance['hide_cover'], 1 ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>"><?php esc_html_e( 'Hide Cover Photo', 'widgets-bundle' ); ?></label>
		</p>

		<p>
			<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_facepile' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_facepile' ) ); ?>" type="checkbox" <?php checked( $instance['show_facepile'], 1 ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_facepile' ) ); ?>"><?php esc_html_e( 'Show Friend\'s Faces', 'widgets-bundle' ); ?></label>
		</p>

		<p>
			<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_header' ) ); ?>" type="checkbox" <?php checked( $instance['small_header'], 1 ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>"><?php esc_html_e( 'Show Small Header', 'widgets-bundle' ); ?></label>
		</p>

		<p>
			<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'container_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'container_width' ) ); ?>" type="checkbox" <?php checked( $instance['container_width'], 1 ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'container_width' ) ); ?>"><?php esc_html_e( 'Adapt to Plugin Container Width', 'widgets-bundle' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_html_e( 'Width', 'widgets-bundle' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['width'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php esc_html_e( 'Height', 'widgets-bundle' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['height'] ); ?>" />
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
			'title'           => esc_html__( 'Like Us On Facebook', 'widgets-bundle' ),
			'app_id'          => '',
			'url'             => 'https://www.facebook.com/facebook',
			'width'           => '400',
			'height'          => '500',
			'small_header'    => 0,
			'container_width' => 0,
			'hide_cover'      => 0,
			'show_facepile'   => 0,
			'show_posts'      => 0,
		);

		return $defaults;
	}

}

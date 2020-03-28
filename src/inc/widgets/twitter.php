<?php

/**
 * Plugin Name: Twitter Widget
 * Description: Widget for Twitter feed.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets;

use WP_Widget;
use AkshitSethi\Plugins\WidgetsBundle\Config;

class Twitter extends WP_Widget {

	/**
	 * @var array
	 */
	protected $theme;

	public function __construct() {

		parent::__construct(
			Config::PREFIX . 'twitter',
			esc_html__( 'Twitter', 'widgets-bundle' ),
			array(
				'classname'   => Config::PREFIX . 'twitter',
				'description' => esc_html__( 'Widget that displays your Twitter feed.', 'widgets-bundle' ),
			)
		);

		// Set theme option
		$this->theme = array(
			'light' => esc_html__( 'Light', 'widgets-bundle' ),
			'dark'  => esc_html__( 'Dark', 'widgets-bundle' ),
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

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="as-wb-twitter">';

		/**
		 * Build Twitter Markup
		 *
		 * @see https://dev.twitter.com/web/embedded-timelines
		 */

		$timeline = '<a class="twitter-timeline"';

		// Data attributes
		$data_attributes = array(
			'width'        => 'width',
			'height'       => 'height',
			'tweet_limit'  => 'tweet-limit',
			'theme'        => 'theme',
			'link_color'   => 'link-color',
			'border_color' => 'border-color',
		);

		foreach ( $data_attributes as $key => $value ) {
			if ( ! empty( $instance[ $key ] ) ) {
				$timeline .= ' data-' . esc_attr( $value ) . '="' . esc_attr( $instance[ $key ] ) . '"';
			}
		}

		// Chrome settings
		if ( ! empty( $instance['chrome'] ) && is_array( $instance['chrome'] ) ) {
			$timeline .= ' data-chrome="' . esc_attr( join( ' ', $instance['chrome'] ) ) . '"';
		}

		// Username
		$timeline .= ' href="https://twitter.com/' . esc_attr( $instance['username'] ) . '"';

		// Close markup
		$timeline .= '>';
		$timeline .= esc_html__( 'Tweets by @', 'widgets-bundle' ) . $instance['username'];
		$timeline .= '</a>';

		// Output
		echo $timeline;

		echo '</div><!-- .as-wb-twitter -->';
		echo $args['after_widget'];

		// Script
		wp_enqueue_script( Config::SHORT_SLUG . '-twitter', Config::$plugin_url . '/assets/js/twitter.js', array( 'jquery' ), Config::VERSION, true );
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
		$new_instance             = wp_parse_args( (array) $new_instance, self::defaults() );
		$instance['title']        = sanitize_text_field( $new_instance['title'] );
		$instance['username']     = sanitize_text_field( $new_instance['username'] );
		$instance['tweet_limit']  = ( $tweet_limit ? $tweet_limit : null );
		$instance['theme']        = $new_instance['theme'];
		$instance['link_color']   = sanitize_hex_color( $new_instance['link_color'] );
		$instance['border_color'] = sanitize_hex_color( $new_instance['border_color'] );
		$instance['chrome']       = array();

		$width       = absint( $new_instance['width'] );
		$height      = absint( $new_instance['height'] );
		$tweet_limit = absint( $new_instance['tweet_limit'] );

		if ( $width ) {
			// From publish.twitter.com: 220 <= width <= 1200
			$instance['width'] = min( max( $width, 220 ), 1200 );
		} else {
			$instance['width'] = '';
		}

		if ( $height ) {
			// From publish.twitter.com: height >= 200
			$instance['height'] = max( $height, 200 );
		} else {
			$instance['height'] = '';
		}

		if ( ! array_key_exists( $instance['theme'], $this->theme ) ) {
			$instance['theme'] = $this->default_instance['theme'];
		}

		$chrome_settings = array(
			'noheader',
			'nofooter',
			'noborders',
			'noscrollbar',
			'transparent',
		);

		if ( isset( $new_instance['chrome'] ) ) {
			foreach ( $new_instance['chrome'] as $chrome ) {
				if ( in_array( $chrome, $chrome_settings ) ) {
					$instance['chrome'][] = $chrome;
				}
			}
		}

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
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username', 'widgets-bundle' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" value="<?php echo esc_attr( $instance['username'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_html_e( 'Width', 'widgets-bundle' ); ?></label>
			<input type="number" min="220" max="1200" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" value="<?php echo esc_attr( $instance['width'] ); ?>" />
			<br/><small><?php echo esc_html__( 'Must be between 220px and 1200px', 'widgets-bundle' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php esc_html_e( 'Height:', 'widgets-bundle' ); ?></label>
			<input type="number" min="200" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" value="<?php echo esc_attr( $instance['height'] ); ?>" />
			<br/><small><?php echo esc_html__( 'Must be atleast 200px', 'widgets-bundle' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tweet_limit' ) ); ?>"><?php esc_html_e( 'Number of Tweets', 'widgets-bundle' ); ?></label>
			<input type="number" min="1" max="20" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tweet_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tweet_limit' ) ); ?>" value="<?php echo esc_attr( $instance['tweet_limit'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'theme' ) ); ?>"><?php esc_html_e( 'Theme', 'widgets-bundle' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'theme' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'theme' ) ); ?>">
				<?php foreach ( $this->theme as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['theme'], $key ); ?>><?php echo esc_html( $value ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link_color' ) ); ?>"><?php esc_html_e( 'Link Color', 'widgets-bundle' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_color' ) ); ?>" value="<?php echo esc_attr( $instance['link_color'] ); ?>" />
			<br/><small><?php echo esc_html__( 'Provide hex value', 'widgets-bundle' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'border_color' ) ); ?>"><?php esc_html_e( 'Border Color', 'widgets-bundle' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'border_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'border_color' ) ); ?>" value="<?php echo esc_attr( $instance['border_color'] ); ?>" />
			<br/><small><?php echo esc_html__( 'Provide hex value', 'widgets-bundle' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'chrome' ) ); ?>"><?php esc_html_e( 'Configure Layout', 'widgets-bundle' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'chrome_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'chrome' ) ); ?>[]" value="noheader"<?php checked( in_array( 'noheader', $instance['chrome'] ) ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'chrome_header' ) ); ?>"><?php esc_html_e( 'No Header', 'widgets-bundle' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'chrome_footer' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'chrome' ) ); ?>[]" value="nofooter"<?php checked( in_array( 'nofooter', $instance['chrome'] ) ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'chrome_footer' ) ); ?>"><?php esc_html_e( 'No Footer', 'widgets-bundle' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'chrome_border' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'chrome' ) ); ?>[]" value="noborders"<?php checked( in_array( 'noborders', $instance['chrome'] ) ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'chrome_border' ) ); ?>"><?php esc_html_e( 'No Borders', 'widgets-bundle' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'chrome_scrollbar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'chrome' ) ); ?>[]" value="noscrollbar"<?php checked( in_array( 'noscrollbar', $instance['chrome'] ) ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'chrome_scrollbar' ) ); ?>"><?php esc_html_e( 'No Scrollbar', 'widgets-bundle' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'chrome_transparent' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'chrome' ) ); ?>[]" value="transparent"<?php checked( in_array( 'transparent', $instance['chrome'] ) ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'chrome_transparent' ) ); ?>"><?php esc_html_e( 'Transparent Background', 'widgets-bundle' ); ?></label>
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
			'title'        => esc_html__( 'Follow Me', 'widgets-bundle' ),
			'username'     => 'akshitsethi',
			'width'        => '',
			'height'       => 400,
			'tweet_limit'  => null,
			'theme'        => 'light',
			'link_color'   => '#3b94d9',
			'border_color' => '#f5f5f5',
			'chrome'       => array(),
		);

		return $defaults;
	}

}

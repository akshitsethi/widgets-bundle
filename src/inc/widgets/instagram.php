<?php

/**
 * Plugin Name: Instagram Widget
 * Description: Widget for showing Instagram photos.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets;

use WP_Widget;
use AkshitSethi\Plugins\WidgetsBundle\Config;

class Instagram extends WP_Widget {

	public function __construct() {
		parent::__construct(
			Config::PREFIX . 'instagram',
			esc_html__( 'Instagram', 'widgets-bundle' ),
			array(
				'classname'   => Config::PREFIX . 'instagram',
				'description' => esc_html__( 'Widget for showing Instagram photos.', 'widgets-bundle' ),
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
		$instance    = wp_parse_args( (array) $instance, self::defaults() );
		$title       = apply_filters( 'widget_title', $instance['title'] );
		$username    = esc_html( $instance['username'] );
		$photos      = absint( $instance['photos'] );
		$photos_row  = $instance['photos_row'];
		$size        = $instance['size'];
		$target      = $instance['target'];
		$show_follow = $instance['show_follow'];
		$follow_text = $instance['follow_text'];

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="as-wb-instagram">';

		// Check
		if ( ! empty( $username ) ) {
			// Feed
			$media = $this->feed( $username, $photos );

			if ( is_wp_error( $media ) ) {
				echo '<p class="as-wb-instagram--error"><span>' . $media->get_error_message() . '</span></p><!-- .as-wb-instagram--error -->';
			} else {
				if ( is_array( $media ) && ! empty( $media ) ) {
					echo '<div class="as-wb-instagram--wrapper">';

					foreach ( $media as $key => $value ) {
						if ( $key >= $photos ) {
							break;
						}

						echo '<div class="as-wb-instagram--item as-wb-instagram--' . absint( $photos_row ) . '">';

						if ( '320px' == $size ) {
							echo '<div class="as-wb-instagram--item-wrapper" style="background-image: url(' . esc_url( $value['url_medium'] ) . ');">';
						} else {
							echo '<div class="as-wb-instagram--item-wrapper" style="background-image: url(' . esc_url( $value['url_thumbnail'] ) . ');">';
						}

						echo '<a href="' . esc_url( $value['link'] ) . '" target="' . esc_attr( $target ) . '"></a>';
						echo '</div><!-- .as-wb-instagram--item-wrapper -->';
						echo '</div><!-- .as-wb-instagram--item -->';
					}

					echo '</div><!-- .as-wb-instagram--wrapper -->';

					// Follow Button
					if ( '1' == $show_follow ) {
						echo '<div class="as-wb-instagram--button"><a href="https://instagram.com/' . $username . '" target="' . esc_attr( $target ) . '">' . esc_html( $follow_text ) . '</a></div><!-- .as-wb-instagram--button -->';
					}
				} else {
					echo '<p class="as-wb-instagram--error"><span>' . esc_html__( 'Unable to grab photos from Instagram.', 'widgets-bundle' ) . '</span></p><!-- .as-wb-instagram--error -->';
				}
			}
		} else {
			echo '<p class="as-wb-instagram--error"><span>' . esc_html__( 'Username has not been provided.', 'widgets-bundle' ) . '</span></p><!-- .as-wb-instagram--error -->';
		}

		echo '</div><!-- .as-wb-instagram -->';
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
		$new_instance            = wp_parse_args( (array) $new_instance, self::defaults() );
		$instance['title']       = sanitize_text_field( $new_instance['title'] );
		$instance['username']    = sanitize_text_field( $new_instance['username'] );
		$instance['photos']      = absint( $new_instance['photos'] );
		$instance['photos_row']  = absint( $new_instance['photos_row'] );
		$instance['size']        = sanitize_text_field( $new_instance['size'] );
		$instance['target']      = sanitize_text_field( $new_instance['target'] );
		$instance['show_follow'] = absint( $new_instance['show_follow'] );
		$instance['follow_text'] = sanitize_text_field( $new_instance['follow_text'] );

		return $instance;
	}


	/**
	 * Widget Form.
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
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['username'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'photos' ) ); ?>"><?php esc_html_e( 'No. of Photos', 'widgets-bundle' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'photos' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'photos' ) ); ?>">
				<option value="1"<?php selected( '1', $instance['photos'] ); ?>><?php esc_html_e( '1', 'widgets-bundle' ); ?></option>
				<option value="2"<?php selected( '2', $instance['photos'] ); ?>><?php esc_html_e( '2', 'widgets-bundle' ); ?></option>
				<option value="3"<?php selected( '3', $instance['photos'] ); ?>><?php esc_html_e( '3', 'widgets-bundle' ); ?></option>
				<option value="4"<?php selected( '4', $instance['photos'] ); ?>><?php esc_html_e( '4', 'widgets-bundle' ); ?></option>
				<option value="5"<?php selected( '5', $instance['photos'] ); ?>><?php esc_html_e( '5', 'widgets-bundle' ); ?></option>
				<option value="6"<?php selected( '6', $instance['photos'] ); ?>><?php esc_html_e( '6', 'widgets-bundle' ); ?></option>
				<option value="7"<?php selected( '7', $instance['photos'] ); ?>><?php esc_html_e( '7', 'widgets-bundle' ); ?></option>
				<option value="8"<?php selected( '8', $instance['photos'] ); ?>><?php esc_html_e( '8', 'widgets-bundle' ); ?></option>
				<option value="9"<?php selected( '9', $instance['photos'] ); ?>><?php esc_html_e( '9', 'widgets-bundle' ); ?></option>
				<option value="10"<?php selected( '10', $instance['photos'] ); ?>><?php esc_html_e( '10', 'widgets-bundle' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'photos_row' ) ); ?>"><?php esc_html_e( 'Photos In a Row', 'widgets-bundle' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'photos_row' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'photos_row' ) ); ?>">
				<option value="1"<?php selected( '1', $instance['photos_row'] ); ?>><?php esc_html_e( '1', 'widgets-bundle' ); ?></option>
				<option value="2"<?php selected( '2', $instance['photos_row'] ); ?>><?php esc_html_e( '2', 'widgets-bundle' ); ?></option>
				<option value="3"<?php selected( '3', $instance['photos_row'] ); ?>><?php esc_html_e( '3', 'widgets-bundle' ); ?></option>
				<option value="4"<?php selected( '4', $instance['photos_row'] ); ?>><?php esc_html_e( '4', 'widgets-bundle' ); ?></option>
				<option value="5"<?php selected( '5', $instance['photos_row'] ); ?>><?php esc_html_e( '5', 'widgets-bundle' ); ?></option>
				<option value="6"<?php selected( '6', $instance['photos_row'] ); ?>><?php esc_html_e( '6', 'widgets-bundle' ); ?></option>
				<option value="7"<?php selected( '7', $instance['photos_row'] ); ?>><?php esc_html_e( '7', 'widgets-bundle' ); ?></option>
				<option value="8"<?php selected( '8', $instance['photos_row'] ); ?>><?php esc_html_e( '8', 'widgets-bundle' ); ?></option>
				<option value="9"<?php selected( '9', $instance['photos_row'] ); ?>><?php esc_html_e( '9', 'widgets-bundle' ); ?></option>
				<option value="10"<?php selected( '10', $instance['photos_row'] ); ?>><?php esc_html_e( '10', 'widgets-bundle' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Image Size', 'widgets-bundle' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>">
				<option value="<?php esc_attr_e( '150px', 'widgets-bundle' ); ?>"<?php selected( '150px', $instance['size'] ); ?>><?php esc_html_e( '150px x 150px', 'widgets-bundle' ); ?></option>
				<option value="<?php esc_attr_e( '320px', 'widgets-bundle' ); ?>"<?php selected( '320px', $instance['size'] ); ?>><?php esc_html_e( '320px x 320px', 'widgets-bundle' ); ?></option>
			</select>
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_follow' ) ); ?>"><?php esc_html_e( 'Show Follow?', 'widgets-bundle' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'show_follow' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_follow' ) ); ?>">
				<option value="<?php esc_attr_e( '1', 'widgets-bundle' ); ?>"<?php selected( '1', $instance['show_follow'] ); ?>><?php esc_html_e( 'Yes', 'widgets-bundle' ); ?></option>
				<option value="<?php esc_attr_e( '2', 'widgets-bundle' ); ?>"<?php selected( '2', $instance['show_follow'] ); ?>><?php esc_html_e( 'No', 'widgets-bundle' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'follow_text' ) ); ?>"><?php esc_html_e( 'Follow Text', 'widgets-bundle' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'follow_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'follow_text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['follow_text'] ); ?>" />
		</p>

		<?php
	}


	/**
	 * Default Options.
	 *
	 * @access private
	 */
	private static function defaults() {
		$defaults = array(
			'title'       => esc_html__( 'Instagram', 'widgets-bundle' ),
			'username'    => '',
			'photos'      => '9',
			'photos_row'  => '3',
			'size'        => '320px',
			'target'      => '_blank',
			'show_follow' => '1',
			'follow_text' => esc_html__( 'Follow Me', 'widgets-bundle' ),
		);

		return $defaults;
	}


	/**
	 * For scraping the instagram feed.
	 *
	 * @link https://gist.github.com/cosmocatalano/4544576
	 */
	private function feed( $username, $slice = 10 ) {
		$username    = strtolower( $username );
		$option_name = Config::PREFIX . 'ig_' . $username;
		$insta_data  = get_transient( $option_name );

		if ( ! $insta_data ) {
			$response = wp_remote_get( 'https://instagram.com/' . trim( $username ) );

			if ( is_wp_error( $response ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'widgets-bundle' ) );
			}

			if ( 200 == $response['response']['code'] ) {
				$json = str_replace( 'window._sharedData = ', '', strstr( $response['body'], 'window._sharedData = ' ) );

				// Compatibility Check
				if ( version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
					$json = strstr( $json, '</script>', true );
				} else {
					$json = substr( $json, 0, strpos( $json, '</script>' ) );
				}

				$json = rtrim( $json, ';' );

				// Function json_last_error() is not available before PHP * 5.3.0 version
				if ( function_exists( 'json_last_error' ) ) {
					( $results = json_decode( $json, true ) ) && json_last_error() == JSON_ERROR_NONE;
				} else {
					$results = json_decode( $json, true );
				}

				if ( $results && is_array( $results ) ) {
					if ( isset( $results['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
						$entry_data = $results['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
					} else {
						$entry_data = array();
					}

					if ( empty( $entry_data ) ) {
						return esc_html__( 'No images found', 'widgets-bundle' );
					}

					foreach ( $entry_data as $current => $result ) {
						if ( $result['node']['__typename'] !== 'GraphImage' ) {
							$slice++;
							continue;
						}

						if ( $current >= $slice ) {
							break;
						}

						$image_data['code']          = $result['node']['shortcode'];
						$image_data['username']      = $username;
						$image_data['user_id']       = $result['node']['owner']['id'];
						$image_data['id']            = $result['node']['id'];
						$image_data['link']          = 'https://instagram.com/p/' . $result['node']['shortcode'];
						$image_data['popularity']    = (int) ( $result['node']['edge_media_to_comment']['count'] ) + ( $result['node']['edge_liked_by']['count'] );
						$image_data['timestamp']     = (float) $result['node']['taken_at_timestamp'];
						$image_data['url']           = $result['node']['display_url'];
						$image_data['url_medium']    = $result['node']['thumbnail_resources'][2]['src'];
						$image_data['url_thumbnail'] = $result['node']['thumbnail_resources'][1]['src'];

						$insta_data[] = $image_data;
					}
				}

				if ( is_array( $insta_data ) && ! empty( $insta_data ) ) {
					set_transient( $option_name, $insta_data, DAY_IN_SECONDS );
				}
			} else {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'widgets-bundle' ) );
			}
		}

		return $insta_data;
	}

}

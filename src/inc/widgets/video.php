<?php

/**
 * Plugin Name: Video Widget
 * Description: Widget for YouTube / Vimeo video.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets {

	use WP_Widget;

	class Video extends WP_Widget {

		public function __construct() {
			parent::__construct(
				'as_wb_video',
				esc_html__( 'Video', 'widgets-bundle' ),
				[
					'classname'   => 'as_wb_video',
					'description' => esc_html__( 'Widget that displays your YouTube or Vimeo video.', 'widgets-bundle' )
				]
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
		 * -------------------------------------------------
		 */

		public function widget( $args, $instance ) {

			$instance 		= wp_parse_args( (array) $instance, self::defaults() );
			$title 			= apply_filters( 'widget_title', $instance['title'] );
			$embed 			= $instance['embed'];
			$description 	= $instance['description'];

			echo $args['before_widget'];

			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			echo '<div class="as-wb-video">';

			// Embed Code
			if ( ! empty( $embed ) ) {
				echo '<div class="as-wb-video-embed">' . html_entity_decode( $embed ) . '</div><!-- .as-wb-video-embed -->';
			}

			// Description
			if ( ! empty( $description ) ) {
				echo '<p>';
				echo wp_kses( $description, array(
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

			echo '</div><!-- .as-wb-video -->';
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

			$new_instance 				= wp_parse_args( (array) $new_instance, self::defaults() );
			$instance['title'] 			= sanitize_text_field( $new_instance['title'] );
			$instance['description'] 	= wp_kses( stripslashes( $new_instance['description'] ), array(
					'a' 		=> array(
						'href' 	=> array(),
						'title' => array()
					),
					'br' 		=> array(),
					'em' 		=> array(),
					'strong' 	=> array()
				) 
			);
			$instance['embed'] 			= htmlentities( stripslashes( $new_instance['embed'] ) );

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
				<label for="<?php echo esc_attr( $this->get_field_id( 'embed' ) ); ?>"><?php esc_html_e( 'Embed Code', 'widgets-bundle' ); ?></label>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'embed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'embed' ) ); ?>"><?php echo esc_textarea( $instance['embed'] ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description', 'widgets-bundle' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['description'] ); ?>" />
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
				'title' 		=> esc_html__( 'Video', 'widgets-bundle' ),
				'embed' 		=> '',
				'description' 	=> esc_html__( 'Here is the latest video. Have fun!', 'widgets-bundle' )
			);

			return $defaults;

		}

	}

}

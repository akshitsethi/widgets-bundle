<?php

/**
 * Plugin Name: Posts Widget
 * Description: Widget for latest posts.
 */

namespace AkshitSethi\Plugins\WidgetsBundle\Widgets {

	class Posts extends WP_Widget {

		public function __construct() {

			parent::__construct( 'as_wb_posts', esc_html__( 'Posts', 'widgets-bundle' ), array(
				'classname'   => 'as_wb_posts',
				'description' => esc_html__( 'Widget that displays your latest posts.', 'widgets-bundle' )
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

			$instance 		= wp_parse_args( (array) $instance, self::defaults() );
			$title 			= apply_filters( 'widget_title', $instance['title'] );
			$categories 	= $instance['categories'];
			$number 		= $instance['number'];
			$as_args 		= array(
								'showposts' 			=> $number,
								'nopaging' 				=> 0,
								'post_status' 			=> 'publish',
								'ignore_sticky_posts' 	=> 1,
								'cat' 					=> $categories,
								'order' 				=> 'ASC',
								'orderby' 				=> 'date'
							);
			$as_query 		= new WP_Query( $as_args );

			echo $args['before_widget'];

			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( $as_query->have_posts() ) :
				echo '<div class="as-wb-posts">';
				echo '<ul>';

				while ( $as_query->have_posts() ) : $as_query->the_post();

	?>

					<li>
						<div class="as-wb-post-item">
							<?php if ( ( function_exists( 'has_post_thumbnail' ) ) && ( has_post_thumbnail() ) ) : ?>
								<div class="as-wb-post-image">
									<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'as-item-image' ) ); ?></a>
								</div><!-- .as-wb-post-image -->
							<?php endif; ?>

							<div class="as-wb-post-text">
								<span class="as-wb-post-meta"><?php echo get_the_category_list( __( ', ', 'widgets-bundle' ) ); ?></span><!-- .as-wb-post-meta -->
								<h4><a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
							</div><!-- .as-wb-post-text -->
						</div><!-- .as-wb-post-item -->
					</li>

	<?php

				endwhile;
				wp_reset_postdata();

				echo '</ul>';
				echo '</div><!-- .as-wb-posts -->';
			endif;

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

			$new_instance 			= wp_parse_args( (array) $new_instance, self::defaults() );
			$instance['title'] 		= sanitize_text_field( $new_instance['title'] );
			$instance['categories'] = sanitize_text_field( $new_instance['categories'] );
			$instance['number'] 	= absint( $new_instance['number'] );

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
				<label for="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>"><?php esc_html_e( 'Categories', 'widgets-bundle' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id('categories') ); ?>" name="<?php echo esc_attr( $this->get_field_name('categories') ); ?>" class="widefat categories">
					<option value="<?php esc_attr_e( 'all', 'widgets-bundle' ); ?>"<?php selected( 'all', $instance['categories'] ); ?>><?php esc_attr_e( 'All', 'widgets-bundle' ); ?></option>
					<?php $categories = get_categories( 'hide_empty=0&depth=1&type=post' ); ?>
					<?php foreach ( $categories as $category ) : ?>
						<option value="<?php echo $category->term_id; ?>" <?php selected( $category->term_id, $instance['categories'] ); ?>><?php echo $category->cat_name; ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of Posts', 'widgets-bundle' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['number'] ); ?>" />
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
				'title' 		=> esc_html__( 'Recent', 'widgets-bundle' ),
				'categories' 	=> '',
				'number' 		=> '4'
			);

			return $defaults;

		}

	}

}

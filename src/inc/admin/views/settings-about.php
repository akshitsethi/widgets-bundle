<?php

/**
 * View: About
 * 
 * @since 1.0.0
 */

?>

<div class="as-tile" id="about">
	<div class="as-tile-body">
		<div class="as-tile-title"><?php esc_html_e( 'ABOUT', 'widgets-bundle' ); ?></div>
			<p><?php esc_html_e( 'Hola! I\'m Akshit Sethi, Designer + Developer by profession & Entrepreneur by passion. In love with WWW and Spanish. Travel is life. When I am not coding, I am reading anything worth reading. I create premium WordPress themes & plugins.', 'widgets-bundle' ); ?></p>

			<div class="as-share">
				<p><?php esc_html_e( 'Show me some love and connect with me via social channels.', 'widgets-bundle' ); ?></p>
				<a href="https://twitter.com/akshitsethi" target="_blank">
					<img src="<?php echo AkshitSethi\Plugins\WidgetsBundle\Config::$plugin_url; ?>assets/admin/img/twitter.png" alt="<?php esc_attr_e( 'Twitter', 'widgets-bundle' ); ?>" />
				</a>

				<a href="https://www.facebook.com/akshitsethi" target="_blank">
					<img src="<?php echo AkshitSethi\Plugins\WidgetsBundle\Config::$plugin_url; ?>assets/admin/img/facebook.png" alt="<?php esc_attr_e( 'Facebook', 'widgets-bundle' ); ?>" />
				</a>
			</div><!-- .as-share -->
		</div><!-- .as-section-content -->
	</div><!-- .as-tile-body -->
</div><!-- #about -->

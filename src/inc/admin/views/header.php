<?php

/**
 * View: Header
 *
 * @since 1.0.0
 */

use AkshitSethi\Plugins\WidgetsBundle\Config;

?>

<div class="as-cnt-fix">
	<div class="as-header as-clearfix">
		<img src="<?php echo Config::$plugin_url; ?>assets/admin/images/lrg-icon.png" alt="<?php echo Config::get_plugin_name(); ?>" class="as-logo">
		<p>
			<strong><?php echo Config::get_plugin_name(); ?></strong>
			<span><?php esc_html_e( 'by', 'widgets-bundle' ); ?> <a href="https://akshitsethi.com/" target="_blank"><?php esc_html_e( 'Akshit Sethi', 'widgets-bundle' ); ?></a></span>
		</p>

		<div class="as-header-right">
			<input type="submit" id="<?php echo Config::PREFIX . 'submit'; ?>" name="<?php echo Config::PREFIX . 'submit'; ?>" class="as-btn" value="<?php esc_attr_e( 'Save Changes', 'widgets-bundle' ); ?>" data-tab="#options">
		</div><!-- .as-header-right -->
	</div><!-- .as-header -->

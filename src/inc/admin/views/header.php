<?php

/**
 * View: Header
 * 
 * @since 1.0.0
 */
	
?>

<div class="as-cnt-fix">
	<div class="as-fix-wp38">
		<div class="as-header as-clearfix">
			<div class="as-header-left">
				<img src="<?php echo AkshitSethi\Plugins\WidgetsBundle\Config::$plugin_url; ?>assets/admin/img/lrg-icon.png" class="as-logo">
				<p>
					<strong><?php esc_html_e( 'Widgets Bundle', 'widgets-bundle' ); ?></strong>
					<span><?php esc_html_e( 'by', 'widgets-bundle' ); ?> <a href="https://akshitsethi.com/" target="_blank"><?php esc_html_e( 'Akshit Sethi', 'widgets-bundle' ); ?></a></span>
				</p>
			</div><!-- .as-header-left -->

			<div class="as-header-right">
				<input type="submit" id="<?php echo AkshitSethi\Plugins\WidgetsBundle\Config::PREFIX . 'submit' ?>" name="<?php echo AkshitSethi\Plugins\WidgetsBundle\Config::PREFIX . 'submit' ?>" class="as-btn" value="<?php esc_html_e( 'Save Changes', 'widgets-bundle' ); ?>" data-tab="options">
			</div><!-- .as-header-right -->
		</div><!-- .as-header -->

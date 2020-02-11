<?php

/**
 * Settings panel view for the plugin.
 * 
 * @since 1.0.0
 */

require_once 'header.php';

?>

<div class="as-body as-clearfix">
	<div class="as-float-left">
		<div class="as-mobile-menu">
			<a href="javascript:void;">
				<img src="<?php echo AkshitSethi\Plugins\WidgetsBundle\Config::$plugin_url; ?>assets/admin/img/toggle.png" alt="<?php esc_attr_e( 'Menu', 'widgets-bundle' ); ?>" />
			</a>
		</div><!-- .as-mobile-menu -->

		<ul class="as-main-menu">
			<li><a href="#options"><?php esc_html_e( 'Options', 'widgets-bundle' ); ?></a></li>
			<li><a href="#support"><?php esc_html_e( 'Support', 'widgets-bundle' ); ?></a></li>
			<li><a href="#license"><?php esc_html_e( 'License', 'widgets-bundle' ); ?></a></li>
			<li><a href="#about"><?php esc_html_e( 'About', 'widgets-bundle' ); ?></a></li>
		</ul>
	</div><!-- .as-float-left -->

	<div class="as-float-right">
		<?php

			// Tabs
			// -------------------------------------------------

			require_once 'settings-options.php';	// options
			require_once 'settings-support.php';	// support
			require_once 'settings-license.php';	// license
			require_once 'settings-about.php';		// about

		?>
	</div><!-- .as-float-right -->
</div><!-- .as-body -->

<?php

require_once 'footer.php';

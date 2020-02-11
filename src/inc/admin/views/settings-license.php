<?php

/**
 * View: License
 *
 * @since 1.0.0
 */

?>

<div class="as-tile" id="license">
	<div class="as-tile-body">
		<div class="as-tile-title"><?php esc_html_e( 'LICENSE', 'widgets-bundle' ); ?></div>
		<div class="as-section-content">
			<?php

				// CHECK : Registration
				if ( get_option( 'as_reg_wb' ) ) :

			?>

					<div class="as-product-wrapper">
						<h1 class="as-product-license"><?php esc_html_e( 'You have a valid license', 'widgets-bundle' ); ?></h1>
						<p class="highlight-key"><span><?php esc_html_e( 'License Key', 'widgets-bundle' ); ?></span> - <?php echo esc_html( get_option( 'as_reg_wb' ) ); ?></p><!-- .highlight-key -->
						<p><?php esc_html_e( 'You have registered the plugin and everything is in good shape. No further action is required from your end. You can now enjoy benefits such as priority support, automatic updates, and exclusive discounts.', 'widgets-bundle' ); ?></p>
					</div><!-- .as-product-wrapper -->

			<?php else : // Not Registered ?>

					<div class="as-product-wrapper">
						<div class="as-product-register">
							<p><?php echo wp_kses( __( 'You do not have an active license for the product. Registration is <strong>absolutely free</strong> and it takes just a click to register the plugin. Registration gets you priority support, immediate bug fixes, and latest updates. Register the <strong>Widgets Bundle</strong> plugin now. It only takes few seconds.', 'widgets-bundle' ), array( 'strong' => array() ) ); ?></p>
							<p><?php esc_html_e( 'Please ensure that you are connected to the Internet and press the button below.', 'widgets-bundle' ); ?></p>

							<div id="as-ajax-response"></div><!-- #as-ajax-response -->

							<form method="post" class="as-register-form">
								<input type="hidden" name="as_email" value="<?php echo get_option( 'admin_email', 'undefined@dontknowwhy.com' ); ?>">
								<input type="hidden" name="as_website" value="<?php echo site_url(); ?>">
								<input type="hidden" name="as_product" value="wb">

								<input type="submit" name="as_submit" class="as-register-button" value="<?php esc_attr_e( 'Register', 'widgets-bundle' ); ?>">
							</form><!-- .as-register-form -->
						</div><!-- .as-product-register -->

						<div class="as-product-benefits">
							<h3><?php esc_html_e( 'Benefits', 'widgets-bundle' ); ?></h3>

							<div class="as-double-group as-clearfix">
								<div class="as-form-group">
									<i class="fa fa-fw fa-refresh"></i>
									<p class="as-title"><?php esc_html_e( 'Automatic Updates', 'widgets-bundle' ); ?></p>
									<p class="as-form-help-block"><?php esc_html_e( 'Manually updating theme is a thing of the past. Keep your site in good health with automatic updates.', 'widgets-bundle' ); ?></p>
								</div>

								<div class="as-form-group">
									<i class="fa fa-fw fa-microphone"></i>
									<p class="as-title"><?php esc_html_e( 'Priority Support', 'widgets-bundle' ); ?></p>
									<p class="as-form-help-block"><?php esc_html_e( 'You are important to us. If you have any issue with our products or anything WordPress, just let us know via the "Support" tab.', 'widgets-bundle' ); ?></p>
								</div>
							</div><!-- .as-double-group -->

							<div class="as-double-group as-clearfix">
								<div class="as-form-group">
									<i class="fa fa-fw fa-bolt"></i>
									<p class="as-title"><?php esc_html_e( 'Important Notifications', 'widgets-bundle' ); ?></p>
									<p class="as-form-help-block"><?php esc_html_e( 'Stay updated with what\'s happening behind the scenes and receive notifications related to product updates, new releases and much more.', 'widgets-bundle' ); ?></p>
								</div>

								<div class="as-form-group">
									<i class="fa fa-fw fa-rupee"></i>
									<p class="as-title"><?php esc_html_e( 'Exclusive Discounts', 'widgets-bundle' ); ?></p>
									<p class="as-form-help-block"><?php esc_html_e( 'Do you have a project for me or need some customizations done? I provide discounts exclusively to the registered users.', 'widgets-bundle' ); ?></p>
								</div>
							</div><!-- .as-double-group -->
						</div><!-- .as-product-benefits -->
					</div><!-- .as-product-wrapper -->

			<?php endif; // get_option ?>
		</div><!-- .as-section-content -->
	</div><!-- .as-tile-body -->
</div><!-- #about -->

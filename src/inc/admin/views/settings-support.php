<?php

/**
 * View: Support
 *
 * @since 1.0.0
 */

use AkshitSethi\Plugins\WidgetsBundle\Config;

?>

<div class="as-tile" id="support">
	<form method="post" class="as-support-form">
		<div class="as-tile-body">
			<h2 class="as-tile-title"><?php esc_html_e( 'SUPPORT', 'widgets-bundle' ); ?></h2>
			<p><?php esc_html_e( 'Getting help is just a click away now. Report the issue you are facing with the plugin using the form below and we will get back to you at the email address provided.', 'widgets-bundle' ); ?></p>

			<div class="as-section-content">
				<div class="as-form-group">
					<label for="<?php echo Config::PREFIX . 'support_email'; ?>" class="as-strong"><?php esc_html_e( 'Email Address', 'widgets-bundle' ); ?></label>
					<input type="text" name="<?php echo Config::PREFIX . 'support_email'; ?>" id="<?php echo Config::PREFIX . 'support_email'; ?>" value="<?php echo esc_attr( $admin_email ); ?>" placeholder="<?php esc_html_e( 'Please provide your email address', 'widgets-bundle' ); ?>" class="as-form-control">

					<p class="as-form-help-block"><?php esc_html_e( 'You will receive support response at this email address.', 'widgets-bundle' ); ?></p>
				</div>

				<div class="as-form-group">
					<label for="<?php echo Config::PREFIX . 'support_issue'; ?>" class="as-strong"><?php esc_html_e( 'Issue / Feedback', 'widgets-bundle' ); ?></label>
					<textarea name="<?php echo Config::PREFIX . 'support_issue'; ?>" id="<?php echo Config::PREFIX . 'support_issue'; ?>" class="as-block as-form-control" rows="10" placeholder="<?php esc_html_e( 'Please explain the issue you are facing with the plugin. Provide as much detail as possible.', 'widgets-bundle' ); ?>"></textarea>

					<p class="as-form-help-block"><?php esc_html_e( 'Please explain the issue you are facing with the plugin. Provide as much detail as possible.', 'widgets-bundle' ); ?></p>
				</div>
			</div><!-- .as-section-content -->
		</div><!-- .as-tile-body -->
	</form><!-- .as-support-form -->
</div><!-- #support -->

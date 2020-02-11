<?php

/**
 * View: Settings
 *
 * @since 1.0.0
 */

?>

<div class="as-tile" id="options">
	<form method="post" class="as-options-form">
		<div class="as-tile-body">
			<h2 class="as-tile-title"><?php esc_html_e( 'OPTIONS', 'widgets-bundle' ); ?></h2>
			<p><?php esc_html_e( 'Configure the widgets in this section. You can enable or disable widgets as per your preference. You can turn off the widgets you do not wish to use and it will not be shown on the "Widgets" page.', 'widgets-bundle' ); ?></p>

			<div class="as-section-content">
				<div class="as-double-group as-clearfix">
					<div class="as-form-group">
						<label for="as_wb_ads" class="as-strong"><?php esc_html_e( 'Ads Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_ads" value="1"<?php checked( '1', $options['ads'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'Widget for displaying "Sponsored" ads.', 'widgets-bundle' ); ?></p>
					</div>

					<div class="as-form-group">
						<label for="as_wb_empty" class="as-strong"><?php esc_html_e( 'Empty Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_empty" value="1"<?php checked( '1', $options['empty'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'Widget for showing empty space between widgets.', 'widgets-bundle' ); ?></p>
					</div>
				</div>

				<div class="as-double-group as-clearfix">
					<div class="as-form-group">
						<label for="as_wb_personal" class="as-strong"><?php esc_html_e( 'Personal Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_personal" value="1"<?php checked( '1', $options['personal'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'Widget for displaying "About Me" information on the website.', 'widgets-bundle' ); ?></p>
					</div>

					<div class="as-form-group">
						<label for="as_wb_posts" class="as-strong"><?php esc_html_e( 'Posts Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_posts" value="1"<?php checked( '1', $options['posts'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'Display posts with thumbnails with the flexibility of selecting between different styles.', 'widgets-bundle' ); ?></p>
					</div>
				</div>

				<div class="as-double-group as-clearfix">
					<div class="as-form-group">
						<label for="as_wb_quote" class="as-strong"><?php esc_html_e( 'Quote Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_quote" value="1"<?php checked( '1', $options['quote'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'Display your favourite quotes with the help of this widget.', 'widgets-bundle' ); ?></p>
					</div>

					<div class="as-form-group">
						<label for="as_wb_social" class="as-strong"><?php esc_html_e( 'Social Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_social" value="1"<?php checked( '1', $options['social'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'Widget for displaying social media links on your website.', 'widgets-bundle' ); ?></p>
					</div>
				</div>

				<div class="as-double-group as-clearfix">
					<div class="as-form-group">
						<label for="as_wb_subscribe" class="as-strong"><?php esc_html_e( 'Subscribe Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_subscribe" value="1"<?php checked( '1', $options['subscribe'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'Mailchimp subscription form with AJAX functionality.', 'widgets-bundle' ); ?></p>
					</div>

					<div class="as-form-group">
						<label for="as_wb_video" class="as-strong"><?php esc_html_e( 'Video Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_video" value="1"<?php checked( '1', $options['video'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'Embed videos on your website with the help of this widget.', 'widgets-bundle' ); ?></p>
					</div>
				</div>

				<div class="as-double-group as-clearfix">
					<div class="as-form-group">
						<label for="as_wb_instagram" class="as-strong"><?php esc_html_e( 'Instagram Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_instagram" value="1"<?php checked( '1', $options['instagram'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'This widget helps you display your photos from Instagram.', 'widgets-bundle' ); ?></p>
					</div>

					<div class="as-form-group">
						<label for="as_wb_facebook" class="as-strong"><?php esc_html_e( 'Facebook Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_facebook" value="1"<?php checked( '1', $options['facebook'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'This widget helps you display your Facebook page feed.', 'widgets-bundle' ); ?></p>
					</div>
				</div>

				<div class="as-double-group as-clearfix">
					<div class="as-form-group">
						<label for="as_wb_twitter" class="as-strong"><?php esc_html_e( 'Twitter Widget', 'widgets-bundle' ); ?></label>
						<input type="checkbox" class="as-form-ios" name="as_wb_twitter" value="1"<?php checked( '1', $options['twitter'] ); ?>>

						<p class="as-form-help-block"><?php esc_html_e( 'This widget helps you display your profile feed from Twitter.', 'widgets-bundle' ); ?></p>
					</div>
				</div>
			</div><!-- .as-section-content -->
		</div><!-- .as-tile-body -->
	</form><!-- .as-options-form -->
</div><!-- #options -->

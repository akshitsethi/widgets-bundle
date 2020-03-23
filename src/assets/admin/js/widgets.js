/**
 * Widgets.js
 * -------------------------------------------------
 */

( function( $ ) {

	'use strict';

	$( function() {
		$( 'h3' ).each( function() {
			var $parent = $( this ).parent().parent().parent();

			if( $parent.attr( 'id' ) !== undefined && $parent.attr( 'id' ) !== false && $parent.attr( 'id' ).indexOf( widgetsbundle_admin.prefix ) > 0 ) {
				$( this ).parents( '.widget-top' ).addClass( 'as-wb-widget-top' );
			}
		} );


		/**
		 * Personal widget.
		 */
		$( document ).on( 'click', '#as-wb-personal-btn', function( e ) {
			e.preventDefault();

			var custom_uploader;
			var attachment;

			// Media uploader.
			if( custom_uploader ) {
				custom_uploader.open();
				return;
			}

			custom_uploader = wp.media.frames.file_frame = wp.media( {
				title: widgetsbundle_js.image_text,
				button: {
					text: widgetsbundle_js.image_text
				},
				multiple: false
			} );

			// Paste URL to text field.
			custom_uploader.on( 'select', function() {
				attachment = custom_uploader.state().get( 'selection' ).first().toJSON();

				$( '.as-wb-personal-url' ).val( attachment.url );
				$( '.as-wb-personal-upload .as-wb-personal-preview' ).html( '<img src="' + attachment.url + '" />' );
				$( '.as-wb-personal-append' ).html( '<a href="javascript:;" id="as-wb-personal-remove">' + widgetsbundle_js.remove_text + '</a>' );

				// Change state.
				$( '.as-wb-personal-upload' ).closest( '.widget' ).find( 'input[type="submit"]' ).val( widgetsbundle_js.save_text ).prop( 'disabled', false );
			} );

			// Open dialog.
			custom_uploader.open();
		} );

		// Remove option.
		$( document ).on( 'click', '#as-wb-personal-remove', function( e ) {
			e.preventDefault();

			$( '.as-wb-personal-url' ).val( '' );
			$( '.as-wb-personal-upload .as-wb-personal-preview' ).html( widgetsbundle_js.image_preview_text );
			$( this ).hide();

			// Change state.
			$( '.as-wb-personal-upload' ).closest( '.widget' ).find( 'input[type="submit"]' ).val( widgetsbundle_js.save_text ).prop( 'disabled', false );
		} );


		/**
		 * Ads Widget.
		 */
		$( document ).on( 'click', '#as-wb-ads-btn', function( e ) {
			e.preventDefault();

			var custom_uploader;
			var attachment;

			// Media uploader.
			if( custom_uploader ) {
				custom_uploader.open();
				return;
			}

			custom_uploader = wp.media.frames.file_frame = wp.media( {
				title: widgetsbundle_js.ad_text,
				button: {
					text: widgetsbundle_js.ad_text
				},
				multiple: false
			} );

			// Paste URL to text field.
			custom_uploader.on( 'select', function() {
				attachment = custom_uploader.state().get( 'selection' ).first().toJSON();

				$( '.as-wb-ads-url' ).val( attachment.url );
				$( '.as-wb-ads-upload .as-wb-ads-preview' ).html( '<img src="' + attachment.url + '" />' );
				$( '.as-wb-ads-append' ).html( '<a href="javascript:;" id="as-wb-ads-remove">' + widgetsbundle_js.remove_text + '</a>' );

				// Change state.
				$( '.as-wb-ads-upload' ).closest( '.widget' ).find( 'input[type="submit"]' ).val( widgetsbundle_js.save_text ).prop( 'disabled', false );
			} );

			// Open dialog.
			custom_uploader.open();
		} );

		// Remove option.
		$( document ).on( 'click', '#as-wb-ads-remove', function( e ) {
			e.preventDefault();

			$( '.as-wb-ads-url' ).val( '' );
			$( '.as-wb-ads-upload .as-wb-ads-preview' ).html( widgetsbundle_js.ad_preview_text );
			$( this ).hide();

			// Change state.
			$( '.as-wb-ads-upload' ).closest( '.widget' ).find( 'input[type="submit"]' ).val( widgetsbundle_js.save_text ).prop( 'disabled', false );
		} );

	} );

})( jQuery );

/**
 * Widgets.js
 * -------------------------------------------------
 */

( function( $ ) {

	'use strict';

	$( function() {
		$( 'h3' ).each( function() {
			var $parent = $( this ).parent().parent().parent();

			if( $parent.attr( 'id' ) !== undefined && $parent.attr( 'id' ) !== false && $parent.attr( 'id' ).indexOf( 'as_wb_' ) > 0 ) {
				$( this ).parents( '.widget-top' ).addClass( 'as-wb-widget-top' );
			}
		} );


		// Personal Widget
		// -------------------------------------------------

		$( document ).on( 'click', '#as-wb-personal-btn', function( e ) {
			e.preventDefault();

			var custom_uploader;
			var attachment;

			// Media Uploader Object
			if( custom_uploader ) {
				custom_uploader.open();
				return;
			}

			custom_uploader = wp.media.frames.file_frame = wp.media( {
				title: as_wb_js.image_text,
				button: {
					text: as_wb_js.image_text
				},
				multiple: false
			} );

			// Paste URL to Text Field
			custom_uploader.on( 'select', function() {
				attachment = custom_uploader.state().get( 'selection' ).first().toJSON();

				$( '.as-wb-personal-url' ).val( attachment.url );
				$( '.as-wb-personal-upload .as-wb-personal-preview' ).html( '<img src="' + attachment.url + '" />' );
				$( '.as-wb-personal-append' ).html( '<a href="javascript:;" id="as-wb-personal-remove">' + as_wb_js.remove_text + '</a>' );

				// Change State
				$( '.as-wb-personal-upload' ).closest( '.widget' ).find( 'input[type="submit"]' ).val( as_wb_js.save_text ).prop( 'disabled', false );
			} );

			// Open Dialog
			custom_uploader.open();
		} );

		// Remove Option
		$( document ).on( 'click', '#as-wb-personal-remove', function( e ) {
			e.preventDefault();

			$( '.as-wb-personal-url' ).val( '' );
			$( '.as-wb-personal-upload .as-wb-personal-preview' ).html( as_wb_js.image_preview_text );
			$( this ).hide();

			// Change State
			$( '.as-wb-personal-upload' ).closest( '.widget' ).find( 'input[type="submit"]' ).val( as_wb_js.save_text ).prop( 'disabled', false );
		} );


		// Ads Widget
		// -------------------------------------------------

		$( document ).on( 'click', '#as-wb-ads-btn', function( e ) {
			e.preventDefault();

			var custom_uploader;
			var attachment;

			// Media Uploader Object
			if( custom_uploader ) {
				custom_uploader.open();
				return;
			}

			custom_uploader = wp.media.frames.file_frame = wp.media( {
				title: as_wb_js.ad_text,
				button: {
					text: as_wb_js.ad_text
				},
				multiple: false
			} );

			// Paste URL to Text Field
			custom_uploader.on( 'select', function() {
				attachment = custom_uploader.state().get( 'selection' ).first().toJSON();

				$( '.as-wb-ads-url' ).val( attachment.url );
				$( '.as-wb-ads-upload .as-wb-ads-preview' ).html( '<img src="' + attachment.url + '" />' );
				$( '.as-wb-ads-append' ).html( '<a href="javascript:;" id="as-wb-ads-remove">' + as_wb_js.remove_text + '</a>' );

				// Change State
				$( '.as-wb-ads-upload' ).closest( '.widget' ).find( 'input[type="submit"]' ).val( as_wb_js.save_text ).prop( 'disabled', false );
			} );

			// Open Dialog
			custom_uploader.open();
		} );

		// Remove Option
		$( document ).on( 'click', '#as-wb-ads-remove', function( e ) {
			e.preventDefault();

			$( '.as-wb-ads-url' ).val( '' );
			$( '.as-wb-ads-upload .as-wb-ads-preview' ).html( as_wb_js.ad_preview_text );
			$( this ).hide();

			// Change State
			$( '.as-wb-ads-upload' ).closest( '.widget' ).find( 'input[type="submit"]' ).val( as_wb_js.save_text ).prop( 'disabled', false );
		} );


		// Notices & Registration
		// -------------------------------------------------
		// AJAX Call

		function as_remove_options( target, action ) {
			$( document ).on( 'click', target, function( e ) {
				e.preventDefault();

				$.ajax( {
					type: 'POST',
					url: ajaxurl,
					data: {
						action: action
					}
				} );
			} );
		}

		as_remove_options( '.as-wb-offer .notice-dismiss', 'as_wb_remove_offer' );
		as_remove_options( '.as-wb-register .notice-dismiss', 'as_wb_remove_reg' );
	} );

})( jQuery );
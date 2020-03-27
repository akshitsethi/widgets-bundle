/**
 * JS code for Widgets in the WP admin panel.
 */
(function ($) {
  'use strict';

  $(function() {
    $('h3').each(function() {
      const $parent = $(this).parent().parent().parent();

      if ($parent.attr('id') !== undefined && $parent.attr('id') !== false && $parent.attr('id').indexOf(widgetsbundle_admin.prefix) > 0) {
        $(this).parents('.widget-top').addClass('as-wb-widget-top');
      }
    });


    /**
     * Personal widget.
     */
    $(document).on('click', '#as-wb-personal-btn', function (e) {
      e.preventDefault();

      let customUploader;
      let attachment;

      // Media uploader
      if (customUploader) {
        customUploader.open();
        return;
      }

      customUploader = wp.media({
        title: widgetsbundle_l10n.image_text,
        button: {
          text: widgetsbundle_l10n.image_text,
        },
        multiple: false,
      });

      // Paste URL to text field.
      customUploader.on('select', () => {
        attachment = customUploader.state().get('selection').first().toJSON();

        $('.as-wb-personal-url').val(attachment.url);
        $('.as-wb-personal-upload .as-wb-personal-preview').html(`<img src="${attachment.url}" />`);
        $('.as-wb-personal-append').html(`<a href="javascript:;" id="as-wb-personal-remove">${widgetsbundle_js.remove_text}</a>`);

        // Change state.
        $('.as-wb-personal-upload').closest('.widget').find('input[type="submit"]').val(widgetsbundle_js.save_text)
          .prop('disabled', false);
      });

      // Open dialog.
      customUploader.open();
    });

    // Remove option.
    $(document).on('click', '#as-wb-personal-remove', function (e) {
      e.preventDefault();

      $('.as-wb-personal-url').val('');
      $('.as-wb-personal-upload .as-wb-personal-preview').html(widgetsbundle_js.image_preview_text);
      $(this).hide();

      // Change state.
      $('.as-wb-personal-upload').closest('.widget').find('input[type="submit"]').val(widgetsbundle_js.save_text)
        .prop('disabled', false);
    });


    /**
     * Ads Widget.
     */
    $(document).on('click', '#as-wb-ads-btn', function (e) {
      e.preventDefault();

      let customUploader;
      let attachment;

      // Media uploader.
      if (customUploader) {
        customUploader.open();
        return;
      }

      customUploader = wp.media({
        title: widgetsbundle_l10n.ad_text,
        button: {
          text: widgetsbundle_l10n.ad_text,
        },
        multiple: false,
      });

      // Paste URL to text field.
      customUploader.on('select', function() {
        attachment = customUploader.state().get('selection').first().toJSON();

        $('.as-wb-ads-url').val(attachment.url);
        $('.as-wb-ads-upload .as-wb-ads-preview').html(`<img src="${attachment.url}" />`);
        $('.as-wb-ads-append').html(`<a href="javascript:;" id="as-wb-ads-remove">${widgetsbundle_js.remove_text}</a>`);

        // Change state.
        $('.as-wb-ads-upload').closest('.widget').find('input[type="submit"]').val(widgetsbundle_js.save_text)
          .prop('disabled', false);
      });

      // Open dialog.
      customUploader.open();
    });

    // Remove option.
    $(document).on('click', '#as-wb-ads-remove', function (e) {
      e.preventDefault();

      $('.as-wb-ads-url').val('');
      $('.as-wb-ads-upload .as-wb-ads-preview').html(widgetsbundle_l10n.ad_preview_text);
      $(this).hide();

      // Change state.
      $('.as-wb-ads-upload').closest('.widget').find('input[type="submit"]').val(widgetsbundle_l10n.save_text)
        .prop('disabled', false);
    });
  });
}(jQuery));

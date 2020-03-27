/**
 * JS code for Widgets in the WP admin panel.
 */
(function ($) {
  'use strict';

  $(function() {
    $('h3').each(function() {
      const $parent = $(this).parent().parent().parent();

      if ($parent.attr('id') !== undefined && $parent.attr('id') !== false && $parent.attr('id').indexOf(widgetsbundle_l10n.prefix) > 0) {
        $(this).parents('.widget-top').addClass('as-wb-widget-top');
      }
    });


    /**
     * Option to upload images to widgets (used by Ads and Personal)
     */
    $(document).on('click', '#as-wb-btn', function (e) {
      e.preventDefault();

      var parent, customUploader, attachment;

      // Find parent as we will be doing the rest of the query against this one
      parent = $(this).parent();

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

      // Paste URL to text field
      customUploader.on('select', () => {
        attachment = customUploader.state().get('selection').first().toJSON();

        $(parent).find('.as-wb-url').val(attachment.url);
        $(parent).find('.as-wb-preview').html(`<img src="${attachment.url}" />`);
        $(parent).find('.as-wb-append').html(`<a href="javascript:;" id="as-wb-remove">${widgetsbundle_l10n.remove_text}</a>`);

        // Change state.
        $(parent).closest('.widget').find('input[type="submit"]').val(widgetsbundle_l10n.save_text)
          .prop('disabled', false);
      });

      // Open dialog
      customUploader.open();
    });

    // Remove option
    $(document).on('click', '#as-wb-remove', function (e) {
      e.preventDefault();

      var parent;

      // Find parent as we will be doing the rest of the query against this one
      parent = $(this).parent().parent();

      $(parent).find('.as-wb-url').val('');
      $(parent).find('.as-wb-preview').html(widgetsbundle_l10n.image_preview_text);
      $(this).hide();

      // Change state
      $(parent).closest('.widget').find('input[type="submit"]').val(widgetsbundle_l10n.save_text)
        .prop('disabled', false);
    });
  });
}(jQuery));

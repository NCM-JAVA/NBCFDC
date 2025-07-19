/**
 * @file
 * Usage Data functionality.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  $(document).ready(function () {
    $.ajax({
      type: 'POST',
      cache: false,
      url: drupalSettings.usage_data.url,
      data: drupalSettings.usage_data.data
    });
  });
})(jQuery, Drupal, drupalSettings);

/**
 * @file
 * Global utilities.
 *
 */
(function($, Drupal) {

  'use strict';
  $(document).ready(function() {
    $('[data-toggle=tooltip]').tooltip();
  });

  Drupal.behaviors.movie_db = {
    attach: function(context, settings) {

      var ids = $('.tooltip-val').map(function (){
        return this.id;
      });
      for (let index = 0; index < ids.length; index++) {
        let vals = $('#'+ids[index]).text();
        $('.tooltip-active-'+ids[index]).attr('title',vals);
        //console.log(vals);

      }

    }
  };

})(jQuery, Drupal);

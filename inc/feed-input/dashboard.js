(function( $ ) {
  var widget = $('#feedinput_dashboard_widget');

  var itemsList = widget.find('.item-list');

  itemsList
    .on( 'click', 'a[data-action="convert-item"]', function( event ) {
      var button = $(this);
      var itemId = button.data('id');
      var item = button.closest( 'li' );

      $.post( ajaxurl, { action: 'feedinput_dashboard_convert_item', id: itemId})
    })
    .on( 'click', 'a[data-action="trash-item"]', function( event ) {

    });

})( jQuery );
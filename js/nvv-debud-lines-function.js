function nvv_debug_lines_select_all() {
  jQuery( '.nvv-check-input_checkbox' ).prop('checked', true);
  nvv_test_content();
}

function nvv_debug_lines_unselect_all() {
  jQuery( '.nvv-check-input_checkbox' ).prop('checked', false);
  nvv_test_content();
}

function nvv_test_content() {
  jQuery( '*' ).removeClass( 'nvv_test_content_line' );
  jQuery( '*' ).css( 'border-color', '' );
  
  jQuery('.nvv-test-rows .nvv-check-input_checkbox:checked').each( function() {
    let selector = jQuery( '#'+this.id ).data( 'nvv_debug_selector' );
    let color = jQuery( '#'+this.id ).data( 'nvv_debug_color' );

    if( selector.indexOf( '*' ) >= 0 ) {
      selector = selector.replace('.', '');
      selector = selector.replace('*', '');

      jQuery( '[class*=\''+selector+'\']' ).addClass( 'nvv_test_content_line' );
      jQuery( '[class*=\''+selector+'\']' ).css( 'border-color', color );
    } else {
      jQuery( selector ).addClass( 'nvv_test_content_line' );
      jQuery( selector ).css( 'border-color', color );
    }
  } );

  let input_selector = jQuery( '#nvv-check-test-object' ).val();
  let input_color = jQuery( '#nvv-check-test-object' ).data( 'nvv_debug_color' );

  if( input_selector.indexOf( '*' ) >= 0 ) {
    input_selector = input_selector.replace('.', '');
    input_selector = input_selector.replace('*', '');

    jQuery( '[class*=\''+input_selector+'\']' ).addClass( 'nvv_test_content_line' );
    jQuery( '[class*=\''+input_selector+'\']' ).css( 'border-color', input_color );
  } else {
    jQuery( input_selector ).addClass( 'nvv_test_content_line' );
    jQuery( input_selector ).css( 'border-color', input_color );
  }
}
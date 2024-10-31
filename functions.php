<?php 

if (!defined('ABSPATH')) {
  exit;
}

/**
* Delete all carbonfields options
*/
if( isset( $_GET['clear_all_nvv_debug_lines_carbonfields_options'] ) && $_GET['clear_all_nvv_debug_lines_carbonfields_options'] == '1'  ) {

  function nvv_debug_lines_delete_carbon_container_fields( $container_id ) {
    $repository = \Carbon_Fields\Carbon_Fields::resolve( 'container_repository' );
    $containers = $repository->get_containers();

    foreach ( $containers as $container ) {
      if ( $container->get_id() !== $container_id ) {
        continue;
      }

      $fields = $container->get_fields();
      foreach ( $fields as $field ) {
        $field->delete();
      }
    }
  
    add_action( 'admin_notices', function() {
      ?>
        <div id="message" class="notice notice-success is-dismissible">
          <p><b><?php esc_html_e( 'All users plugin options cleared', 'nvv-debug-lines' ) ?>.</b></p>
        </div>
      <?php
    } );

  }

  $container_id = 'carbon_fields_container_nvv_debug_lines_options';
  nvv_debug_lines_delete_carbon_container_fields( $container_id );

}
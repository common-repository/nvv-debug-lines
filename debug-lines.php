<?php 

if (!defined('ABSPATH')) {
  exit;
}

$selectors = carbon_get_theme_option( 'nvv_debug_lines_lines' );
?>

<style>
  .nvv_test_content_line:not( .nvv-test-rows .nvv_test_content_line ) {
    border: <?php echo get_option( '_nvv_debug_lines_stroke_line' ) ?>px <?php echo get_option( '_nvv_debug_lines_line_type' ) ?> green;
  }
</style>

<div class="nvv-test-rows">
  <div class="hover_area"></div>
  <div class="nvv-test-rows-header">
    <label for="select_all" onclick="nvv_debug_lines_select_all()"><?php esc_html_e( 'Select All', 'nvv-debug-lines' ) ?></label>
    <label for="unselect_all" onclick="nvv_debug_lines_unselect_all()"><?php esc_html_e( 'Unselect All', 'nvv-debug-lines' ) ?></label>
  </div>

  <hr style="margin: 3px 0 0;">

  <ul class="ul" onchange="nvv_test_content()">
    <li>
      <div class="nvv-box-color" style="background-color: <?php echo get_option( '_nvv_debug_lines_free_input_color' ) ?>"></div>
      <div class="nvv_wrap_input">
        <span class="clear_input" title="<?php esc_html_e( 'Clear', 'nvv-debug-lines' ) ?>" onclick="jQuery( '#nvv-check-test-object' ).val(''); nvv_test_content();">x</span>
        <input type="text" id="nvv-check-test-object" data-nvv_debug_selector="" data-nvv_debug_color="<?php echo get_option( '_nvv_debug_lines_free_input_color' ) ?>" placeholder="CSS-selector" onchange="jQuery(this).attr('data-nvv_debug_selector', jQuery(this).val())">
      </div>
    </li>
    
    <?php $i = 0; foreach( $selectors as $value ): ?>
      <li>
        <div class="nvv-box-color" style="background-color: <?php echo esc_attr( $value['color'] ) ?>"></div>
        <input type="checkbox" id="nvv-check-test-<?php echo $i ?>" class="nvv-check-input_checkbox" data-nvv_debug_selector="<?php echo esc_attr( $value['element'] ) ?>" data-nvv_debug_color="<?php echo esc_attr( $value['color'] ) ?>">
        <label for="nvv-check-test-<?php echo $i ?>"><?php echo esc_attr( $value['element'] ) ?></label>
      </li>
    <?php $i++; endforeach; ?>
  </ul>
</div><!-- /.nvv-test-rows -->
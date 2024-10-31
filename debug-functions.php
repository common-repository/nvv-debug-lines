<?php 

if (!defined('ABSPATH')) {
  exit;
}

/**
* Local variables
**/
global $background_color, $font_color;

$background_color = '' != get_option( '_nvv_debug_lines_debug_background_color' ) ? get_option( '_nvv_debug_lines_debug_background_color' ) : '#808080';
$font_color = '' != get_option( '_nvv_debug_lines_debug_font_color' ) ? get_option( '_nvv_debug_lines_debug_font_color' ) : '#ffffff';

/**
* NVV debug function
*/

function nvvd( $data, $die = false ){
  global $background_color, $font_color;

  $var_dump = get_option( '_nvv_debug_lines_display_vardump' );

  echo '<div class="wrap_nvv_debug" style="background-color:' . esc_attr( $background_color ) . '; color:' . esc_attr( $font_color ) . '; padding:10px; font-size: 12px;">';
  if( false != $var_dump ) {
    echo '<pre style="margin:10px 0 0 0; border-top: 1px solid #ccc;">' . var_dump( $data ) . print_r( $data, true) . '</pre>';
  } else {
    echo '<pre>' . print_r( $data, true) . '</pre>';
  }
  
  echo '</div><!-- /.wrap_nvv_debug --><hr>';
  if( $die ) {
    die();
  };
}

function nvvdl( $data ){
  $file_path = WP_CONTENT_DIR . "/nvv_debug.log";
  $separate_line = '***********************************';

  $log = current_time( 'Y-m-d H:i:s', $gmt = 0 ) . ' UTC' . PHP_EOL;
  $log .= $separate_line . PHP_EOL . PHP_EOL;
  
  ob_start();
  nvvd( $data );
  $out = ob_get_contents();
  ob_end_clean();
  
  $out = $log . nvv_debug_lines_strip_all_tags( $out );
  $out .= PHP_EOL . PHP_EOL . $separate_line . PHP_EOL . PHP_EOL;
  
  file_put_contents( $file_path, $out, FILE_APPEND );
}

function nvv_debug_lines_strip_all_tags( $string, $remove_breaks = false ) {
  $string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
  $string = strip_tags( $string );

  if ( $remove_breaks ) {
    $string = preg_replace( '/[\r\n\t ]+/', ' ', $string );
  }

  return trim( $string );
}
/* /NVV debug function */

/**
* Add debug lines
*/

if( get_option( '_nvv_debug_lines_display_lines_panel' ) ){
  add_action( 'wp_head', 'nvv_debug_lines_action_head' );
  function nvv_debug_lines_action_head(){

    require_once plugin_dir_path( __FILE__ ) . 'debug-lines.php';

  }
}

<?php 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

use Carbon_Fields\Container;

require_once plugin_dir_path( __FILE__ )  . 'nvv-debug-lines-options.php';

add_action( 'after_setup_theme', 'nvv_debug_lines_load' );
function nvv_debug_lines_load() {
  \Carbon_Fields\Carbon_Fields::boot();
}

//Options styles
add_action( 'admin_head', 'nvv_debug_lines_options_styles' );
function nvv_debug_lines_options_styles(){
  ?>
    <style>
      .cf-container__tabs-item {
        font-weight: bold;
        font-size: 1.1em !important;
        opacity: 0.6;
      }

      .cf-container__tabs-item--current {
        opacity: 1;
      }
    </style>
  <?php
}
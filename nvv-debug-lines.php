<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://nvvdesign.top/
 * @since             1.0.1
 * @package           Nvv_Debug_Lines
 *
 * @wordpress-plugin
 * Plugin Name:       NVV Debug Lines
 * Plugin URI:        https://nvvdesign.top/nvv-debug-lines
 * Description:       Help for developers. Highlighting blocks of code with colored lines. Functions for debugging code.
 * Version:           1.0.1
 * Author:            NVV Design
 * Author URI:        https://nvvdesign.top/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nvv-debug-lines
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'NVV_DEBUG_LINES_VERSION', '1.0.1' );

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
require_once plugin_dir_path( __FILE__ ) . 'options/carbonfields/includes-carbon-custom-files.php';

/**
* Localization
**/
load_plugin_textdomain( 'nvv-debug-lines', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );  

/**
* Activate, deactivate plugin
**/
function activate_nvv_debug_lines() {
	
}

function deactivate_nvv_debug_lines() {

}

register_activation_hook( __FILE__, 'activate_nvv_debug_lines' );
register_deactivation_hook( __FILE__, 'deactivate_nvv_debug_lines' );
/* /Activate, deactivate plugin */

if( WP_DEBUG ) {
  require plugin_dir_path( __FILE__ ) . 'debug-functions.php';
}

function nvv_debug_lines_scripts() {

  wp_enqueue_style( 'nvv_debug_lines_style', plugins_url( 'css/nvv-debud-lines-styles.css', __FILE__ ), '', NVV_DEBUG_LINES_VERSION );

  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'nvv_debug_lines_functions_js', plugins_url( 'js/nvv-debud-lines-function.js', __FILE__ ), array( 'jquery' ), NVV_DEBUG_LINES_VERSION );

}
add_action( 'wp_enqueue_scripts', 'nvv_debug_lines_scripts' );

add_action( 'init', function(){

  require_once plugin_dir_path( __FILE__ ) . 'functions.php';

} );


//Custom action links
add_filter( 'plugin_action_links', 'nvv_debug_lines_plugin_action_links', 10, 2 );
function nvv_debug_lines_plugin_action_links( $actions, $plugin_file ){
  if( false === strpos( $plugin_file, basename(__FILE__) ) )
    return $actions;

  $settings_link = '<a href="options-general.php?page=nvv_debug_lines_options' .'">'.esc_html__( 'Settings', 'nvv-debug-lines' ).'</a>'; 
  $clear_options_link = '<a href="plugins.php?clear_all_nvv_debug_lines_carbonfields_options=1' .'" title="'.esc_html__( 'Clearing all user options from the database', 'nvv-debug-lines' ).'" onclick="return confirm(\''. esc_html__( 'Warning! All user options will be removed forever!', 'nvv-debug-lines' ) .'\')">'.esc_html__( 'Clear options', 'nvv-debug-lines' ).'</a>'; 
  
  array_unshift( $actions, $settings_link, $clear_options_link ); 
  
  return $actions; 
}
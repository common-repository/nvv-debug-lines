<?php 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'nvv_debug_lines_options' );
function nvv_debug_lines_options() {

  Container::make( 'theme_options', 'nvv_debug_lines_options', esc_html__( 'NVV Debug Lines options', 'nvv-debug-lines' ) )
    ->set_page_menu_position( 100 )
    ->set_icon('dashicons-layout')
    ->set_page_file( 'nvv_debug_lines_options' )
    ->set_page_parent( 'options-general.php' )

    ->add_tab( esc_html__( 'Lines options', 'nvv-debug-lines' ), array(

      Field::make( 'html', 'nvv_debug_lines_options_info', '' )
        ->set_html( nvv_debug_lines_info_wp_debug() ),

      Field::make( 'checkbox', 'nvv_debug_lines_display_lines_panel', esc_html__( 'Display Lines panel', 'nvv-debug-lines' ) )
        ->set_default_value( 'yes' ),

      Field::make( 'text', 'nvv_debug_lines_stroke_line', esc_html__( 'Stroke line weight (px)', 'nvv-debug-lines' ) )
        ->set_attribute( 'type', 'number' )
        ->set_attribute( 'min', '1' )
        ->set_attribute( 'max', '5' )
        ->set_default_value( '1' )
        ->set_width( 30 ),

      Field::make( 'select', 'nvv_debug_lines_line_type', esc_html__( 'Line Type', 'nvv-debug-lines' ) )
        ->add_options( array(
          'solid'   => 'Solid',
          'dashed'  => 'Dashed',
          'dotted'  => 'Dotted',
          'double'  => 'Double',
        ) )
        ->set_width( 70 )
        ->set_default_value( 'dashed' ),

      Field::make( 'color', 'nvv_debug_lines_free_input_color', esc_html__( 'Free Input Field Color', 'nvv-debug-lines' ) )
        ->set_default_value( '#008000' ),

      Field::make( 'complex', 'nvv_debug_lines_lines', esc_html__( 'List of CSS selectors for displaying in the panel:', 'nvv-debug-lines' ) )
      ->add_fields( array(
        Field::make( 'text', 'element', __( 'Element', 'nvv-debug-lines' ) )->set_width( 70 )
          ->set_help_text( esc_html__( 'CSS selector. Example: "div" "p" ".class_name" "#id_code". ("*" - any characters (only in classes))', 'nvv-debug-lines' ) ),
        Field::make( 'color', 'color', esc_html__( 'Color', 'nvv-debug-lines' ) )->set_width( 30 ),
        ) )->set_header_template( '
            <% if (element) { %>
                <%- element %>
            <% } %>
        ' )
          ->set_default_value( array(
              array(
                'element' => '.container',
                'color'   => '#FF0000'
              ),
              array(
                'element' => '.container-fluid',
                'color'   => '#FF0000'
              ),
              array(
                'element' => '.row',
                'color'   => '#0000FF'
              ),
              array(
                'element' => '.col-*',
                'color'   => '#FFA500'
              ),
              array(
                'element' => 'div',
                'color'   => '#008000'
              ),
              array(
                'element' => 'p',
                'color'   => '#008000'
              ),
              array(
                'element' => 'a',
                'color'   => '#007EFF'
              ),
              array(
                'element' => '#content',
                'color'   => '#FF00F2'
              ),
            ) ),

    ) )

    ->add_tab( esc_html__( 'Debug options', 'nvv-debug-lines' ), array(

      Field::make( 'html', 'nvv_debug_lines_debug_options_info', '' )
        ->set_html( nvv_debug_lines_info_wp_debug() ),

      Field::make( 'color', 'nvv_debug_lines_debug_background_color', esc_html__( 'Background color', 'nvv-debug-lines' ) )
        ->set_alpha_enabled( true )->set_width(50)->set_default_value( '#808080' ),
      Field::make( 'color', 'nvv_debug_lines_debug_font_color', esc_html__( 'Font color', 'nvv-debug-lines' ) )
        ->set_alpha_enabled( true )->set_width(50)->set_default_value( '#FFFFFF' ),

      Field::make( 'checkbox', 'nvv_debug_lines_display_vardump', esc_html__( 'Display var_dump()', 'nvv-debug-lines' ) )
        ->set_default_value( 'yes' )
        ->set_help_text( esc_html__( 'Additionally display structured information', 'nvv-debug-lines' ) . '<br><img src="'. plugins_url( 'images/var_dump_pict.png', __FILE__ ) .'" width="280">' )
        ->set_width(40),

      Field::make( 'html', 'nvv_debug_lines_debug_functions_info', '' )
        ->set_html( nvv_debug_lines_debug_functions_info_cb() ),
    ) )
   
   ;
}

function nvv_debug_lines_info_wp_debug(){
  $out = '';

  if( false === get_option( '_nvv_debug_lines_display_lines_panel' ) ) {
    $out .= '<span style="color:red; font-weight: bold">';
    $out .= esc_html__( 'Click "Save Changes"!', 'nvv-debug-lines' );
    $out .= '</span>';
  }
  
  if( WP_DEBUG == false ) {
    $out .= '<h4 style="margin-bottom: 0;">' . esc_html__( "WordPress debug mode is disabled. Debug functions do not work in this mode.", "nvv-debug-lines") . '</h4>';
    $out .= '<p style="margin-top: 0;">wp-config.php -> define( "WP_DEBUG", false ). <br>To enable debug mode, you need to enter - define( "WP_DEBUG", true )</p>';
  }

   return $out;
}

function nvv_debug_lines_debug_functions_info_cb(){

  return ' 
          <h3>'. esc_html__( 'Functions to help the developer to debug the code', 'nvv-debug-lines' ) .':</h3>
          <hr>
          <p>'. esc_html__( 'Function', 'nvv-debug-lines' ) .': <b>nvvd( $variable, false )</b><br>
          '. esc_html__( 'Allows to display data to screen', 'nvv-debug-lines' ) .'</p>
          <p>'. esc_html__( 'For example', 'nvv-debug-lines' ) .':</p>
          <p>$variable = array( "1" => "a", "2" => "b" );<br>
          nvvd( $variable );</p>
          <p>'. esc_html__( 'Result on screen', 'nvv-debug-lines' ) .':<br>
          </p>

          <div class="wrap_nvv_debug" style="background-color:'. get_option( '_nvv_debug_lines_debug_background_color' ) .'; color:'. get_option( '_nvv_debug_lines_debug_font_color' ) .'; padding:10px; font-size: 12px;">array(2) {
            [1]=&gt;
            string(1) "a"
            [2]=&gt;
            string(1) "b"
          }
    <pre style="margin:10px 0 0 0; border-top: 1px solid #ccc;">Array
    (
        [1] =&gt; a
        [2] =&gt; b
    )
    </pre></div>
         
          <p>'. esc_html__( 'To stop the execution of the program, you need to enter', 'nvv-debug-lines' ) .' "true":<br>
          nvvd( $variable, true );
          </p>
          <hr>
          <p>'. esc_html__( 'Function', 'nvv-debug-lines' ) .': <b>nvvdl( $variable )</b><br>
          '. esc_html__( 'This function does the same, but outputs data to a file.', 'nvv-debug-lines' ) .'<br>
          '. esc_html__( 'File path', 'nvv-debug-lines' ) .': <i>wp-content/nvv_debug.log</i>
          </p>

         ';
}
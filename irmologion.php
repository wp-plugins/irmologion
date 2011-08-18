<?php
/*
Plugin Name: Irmologion
Plugin URI: http://vidanov.com/irmologion
Description: Церковно-славянский шрифт на сайте
Version: 1.01
Author: Vidanov
Author URI: http://vidanov.com
*/
add_action('wp_print_styles', 'irmologion_styles');
function irmologion_styles() {
global $pluginfolder;

 wp_register_style('irmologion', WP_PLUGIN_URL .'/irmologion/main.css');
wp_enqueue_style('irmologion', WP_PLUGIN_URL .'/irmologion/main.css');


}



	if ( ! function_exists('irmologion_css') ) {
  function irmologion_css() {
         $s= ',' . WP_PLUGIN_URL .'/irmologion/main.css';
	return $s ;
	    }
	}
	add_filter( 'mce_css', 'irmologion_css' );


 if ( ! function_exists( 'irmologion_formatTinyMCE' ) ) :
function irmologion_formatTinyMCE($init) {
  $init['theme_advanced_buttons2_add'] = 'styleselect';
  $init['theme_advanced_styles'] = 'Церковно-славянский=slavic';
  
  return $init;
}
endif;

add_filter('tiny_mce_before_init', 'irmologion_formatTinyMCE' );





?>
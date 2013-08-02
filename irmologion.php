<?php
	/*
	Plugin Name: Irmologion
	Plugin URI: http://studio.hamburg-hram.de/plugins/irmologion-wordpress-plugin/
	Description: This WordPress plugin enables to add texts in church slavonic to WordPress blogs.
	Version: 1.2.0

	Author: Hamburg Church Studio
	Author URI: http://studio.hamburg-hram.de/

	License: GPLv2 or later
	*/


	if ( ! function_exists( 'irmologion_styles' ) ) {
		function irmologion_styles() {

			wp_register_style( 'irmologion', WP_PLUGIN_URL . '/irmologion/main.css' );
			wp_enqueue_style( 'irmologion' );

		}
	}
	add_action( 'wp_enqueue_scripts', 'irmologion_styles' );


	if ( ! function_exists( 'irmologion_css' ) ) {
		function irmologion_css( $mce_css ) {

			if ( ! empty( $mce_css ) )
				$mce_css .= ',';

			$mce_css .= plugins_url( 'main.css', __FILE__ );
			return $mce_css;
		}
	}
	add_filter( 'mce_css', 'irmologion_css' );


	if ( ! function_exists( 'irmologion_change_tinymce_settings' ) ) {
		function irmologion_change_tinymce_settings ( $settings ) {

			$rows_names = array( 'theme_advanced_buttons1' , 'theme_advanced_buttons2' , 'theme_advanced_buttons3' , 'theme_advanced_buttons4' );
			$is_styleselect_available = false;

			foreach ( $rows_names as $row ) {
				if ( isset( $settings[$row] ) && strpos( $settings[$row] , 'styleselect' ) !== false ) {
					$is_styleselect_available = true;
				}
			}

			if ( ! $is_styleselect_available ) {
				$settings['theme_advanced_buttons2'] .= ',styleselect';
			}

			//Delimit styles by semicolon in format 'Title=classes;' so TinyMCE can use it
			if ( isset( $settings['theme_advanced_styles'] ) && ! empty( $settings['theme_advanced_styles'] ) ) {
				$settings['theme_advanced_styles'] .= ';';
			} else {
				$settings['theme_advanced_styles'] = '';
			}

			//Add our new class settings to the TinyMCE $settings array
			$settings['theme_advanced_styles'] .= 'Церковно-славянский=slavic';


			$style_formats = array(
				// Each array child is a format with it's own settings
				array(
					'title' => 'Церковно-славянский стиль',
					'block' => 'p',
					'classes' => 'slavic'
				)
			);
			// Insert the array, JSON ENCODED, into 'style_formats'
			$settings['style_formats'] = json_encode( $style_formats );


			return $settings;
		}
	}
	add_filter( 'tiny_mce_before_init', 'irmologion_change_tinymce_settings' );

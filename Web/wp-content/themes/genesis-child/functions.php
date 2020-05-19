<?php
/**
 * Requires (pulls in) the initializing functions of Dynamik
 * which are found in the /lib/init.php file.
 *
 * @package Dynamik
 */
 
/**
 * Include Genesis theme files
 */
require_once( get_template_directory() . '/lib/init.php' );

/**
 * Include Dynamik theme files
 */
require_once( get_stylesheet_directory() . '/lib/init.php' );


/* Enqueues scripts and styles */
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
function genesis_sample_enqueue_scripts_styles() {
wp_enqueue_style( 'style', get_stylesheet_uri(). '' );
}

remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav' );
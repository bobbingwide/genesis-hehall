<?php // (C) Copyright Bobbing Wide 2016

/**
 * This file adds the Front Page
 *
 */

add_action( 'genesis_meta', 'hehall_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function hehall_home_genesis_meta() {

	if ( is_active_sidebar( 'home-section-1' ) || is_active_sidebar( 'home-section-2' ) || is_active_sidebar( 'home-section-3' ) || is_active_sidebar( 'home-section-4' ) || is_active_sidebar( 'home-section-5' ) ) {

		//* Enqueue parallax script
		add_action( 'wp_enqueue_scripts', 'hehall_enqueue_parallax_script' );

		//* Add parallax-home body class
		add_filter( 'body_class', 'parallax_body_class' );
		function parallax_body_class( $classes ) {
		
   			$classes[] = 'parallax-home';
  			return $classes;
  			
		}

		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//* Remove primary navigation
		//remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add homepage widgets
		add_action( 'genesis_loop', 'hehall_homepage_widgets' );

	}
}

//* Add markup for homepage widgets
function hehall_homepage_widgets() {

	genesis_widget_area( 'home-section-1', array(
		'before' => '<div class="home-odd home-section-1 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-2', array(
		'before' => '<div class="home-even home-section-2 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-3', array(
		'before' => '<div class="home-odd home-section-3 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-4', array(
		'before' => '<div class="home-even home-section-4 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-section-5', array(
		'before' => '<div class="home-odd home-section-5 widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

/**
 * Enqueue the parallax script
 * 
 * Note: In Parallax-Pro the script is not enqueued for mobile devices
 * I don't know why not. 
 * Perhaps the JavaScript doesn't work at all on mobile.
 * How can we test this?
 */
function hehall_enqueue_parallax_script() {

//if ( ! wp_is_mobile() ) {

	wp_enqueue_script( 'parallax-script', get_bloginfo( 'stylesheet_directory' ) . '/js/parallax.js', array( 'jquery' ), '1.0.0' );

//}

}

genesis();

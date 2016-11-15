<?php // (C) Copyright Bobbing Wide 2015,2016

hehall_loaded();

/**
 * Function to run when theme is loaded
 */
function hehall_loaded() {

	//* Child theme (do not remove)
	define( 'CHILD_THEME_NAME', 'Halls Garage' );
	define( 'CHILD_THEME_URL', 'http://www.bobbingwide.com/oik-themes' );
	define( 'CHILD_THEME_VERSION', '0.1.0' );
	
	//* Start the engine - we only need to do this if we want to invoke genesis_ functions
  include_once( get_template_directory() . '/lib/init.php' );

	//* Enqueue Google Fonts and Dashicons and styles
	add_action( 'wp_enqueue_scripts', 'hehall_enqueue_scripts' );
	add_action( 'wp_enqueue_scripts', 'hehall_enqueue_styles' );


	//* Add HTML5 markup structure
	add_theme_support( 'html5', array( 'search-form'
	//, 'comment-form', 'comment-list'
	 ) );

	//* Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	//* Add support for custom background
	add_theme_support( 'custom-background' );

	//* Add support for 3-column footer widgets
	add_theme_support( 'genesis-footer-widgets', 3 );

	add_filter( 'genesis_footer_creds_text', "hehall_footer_creds_text" );
	
	//* No need for localization in this instance
	//load_child_theme_textdomain( 'parallax', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'parallax' ) );
	
	//* Add Image upload to WordPress Theme Customizer
	add_action( 'customize_register', 'hehall_customizer' );

	//* Include Section Image CSS
	include_once( get_stylesheet_directory() . '/lib/output.php' );



	//* Reposition the primary navigation menu
	//remove_action( 'genesis_after_header', 'genesis_do_nav' );
	//add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

	//* Reposition the secondary navigation menu to after the footer
	// We probably don't need this
	remove_action( 'genesis_after_header', 'genesis_do_subnav' );
	add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

	//* Reduce the secondary navigation menu to one level depth
	add_filter( 'wp_nav_menu_args', 'hehall_secondary_menu_args' );

	//* Unregister layout settings
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	//* Add support for additional color styles
	//add_theme_support( 'genesis-style-selector', array(  'parallax-pro-blue'   => __( 'Parallax Pro Blue', 'parallax' ) ) );

	//* Unregister secondary sidebar
	unregister_sidebar( 'sidebar-alt' );

	//* Add support for custom header
	// @TODO Adjust size in stylesheet?
	add_theme_support( 'custom-header', array(
		'width'           => 360,
		'height'          => 70,
		'header-selector' => '.site-title a',
		'header-text'     => false,
		) );

	//* Add support for structural wraps
	add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'nav',
		'subnav',
		'footer-widgets',
		'footer',
	) );

	//* Hook after post widget after the entry content
	//add_action( 'genesis_after_entry', 'parallax_after_entry', 5 );
	//function parallax_after_entry() {
	//
	//	if ( is_singular( 'post' ) )
	//		genesis_widget_area( 'after-entry', array(
	//			'before' => '<div class="after-entry widget-area">',
	//			'after'  => '</div>',
	//		) );
	//
	//}
	hehall_widget_areas();
	

}

/**
 * Display footer credits
 */
function hehall_footer_creds_text( $text ) {
  $text = "[bw_copyright] <br />[bw_wpadmin]"; 
  return( $text );
}

/**
 * Enqueue styles
 * 
 * - Google fonts are necessary since style.css uses Lato
 * - dashicons may not be necessary
 */
function hehall_enqueue_styles() {
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );
}

/**
 * Enqueue scripts
 * 
 * - responsive-menu for the hamburger menu
 * - parallax is only added on the front-page
 */
function hehall_enqueue_scripts() {
	wp_enqueue_script( 'parallax-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
}


/**
 * Implement customizer for the background images on the front-page
 */
function hehall_customizer(){

	require_once( get_stylesheet_directory() . '/lib/customize.php' );
	
}

/**
 * Implement 'wp_nav_menu_args' for the secondary menu
 * 
 * @param array $args
 * @return array updated if it's the secondary menu
 */ 
function hehall_secondary_menu_args( $args ){
	if( 'secondary' == $args['theme_location'] ) {
		$args['depth'] = 1;
	}
	return $args;
}

/**
 * Register the front-page widget areas
 */
function hehall_widget_areas() {
	for ( $i = 1; $i <= 5; $i++ ) {
		genesis_register_sidebar( array(
			'id'          => "home-section-$i"
			,'name'        => "Home Section $i"
			,'description' => "This is home section $i"
		) );
	}
	//genesis_register_sidebar( array(
	//	'id'          => 'after-entry',
	//	'name'        => __( 'After Entry', 'parallax' ),
	//	'description' => __( 'This is the after entry widget area.', 'parallax' ),
	//) );


}	


<?php

/* Load Omega theme framework. */
require ( trailingslashit( get_template_directory() ) . 'lib/framework.php' );
new Omega();

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function omega_theme_setup() {

	/* Load omega functions */
	require get_template_directory() . '/lib/hooks.php';

	/* The best thumbnail/image script ever. */
	add_theme_support( 'get-the-image' );
	
	/* Load scripts. */
	add_theme_support( 
		'omega-scripts', 
		array( 'comment-reply' ) 
	);
	
	add_theme_support( 'omega-theme-settings' );

	/* Enable custom template hierarchy. */
	//add_theme_support( 'omega-template-hierarchy' );

	/* Enable theme layouts (need to add stylesheet support). */
	add_theme_support( 
		'theme-layouts', 
		array(
			'1c'        => __( 'Content',           'omega' ),
			'2c-l'      => __( 'Content / Sidebar', 'omega' ),
			'2c-r'      => __( 'Sidebar / Content', 'omega' )
		),
		array( 'default' => is_rtl() ? '2c-r' :'2c-l', 'customizer' => true ) 
	);
		
	/* implement editor styling, so as to make the editor content match the resulting post output in the theme. */
	add_editor_style();

	/* Support pagination instead of prev/next links. */
	add_theme_support( 'loop-pagination' );	

	/* Better captions for themes to style. */
	add_theme_support( 'cleaner-caption' );

	/* Add default posts and comments RSS feed links to <head>.  */
	add_theme_support( 'automatic-feed-links' );

	/* Enable wraps */
	add_theme_support( 'omega-wraps' );

	/* Enable custom css */
	add_theme_support( 'omega-custom-css' );
	
	/* Enable custom logo */
	add_theme_support( 'omega-custom-logo' );

	/* Enable child themes page */
	add_theme_support( 'omega-child-page' );


	/* Handle content width for embeds and images. */
	omega_set_content_width( 640 );

}

add_action( 'after_setup_theme', 'omega_theme_setup' );

/**
 * Disable WordPress theme update checks
 * If there is a theme in the repo with the same name,
 * this prevents WP from prompting an update.
 *
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 * @author Mark Jaquith
 * @since 1.0.0
 *
 **/

function afn_prevent_theme_update( $r, $url ) {
    if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
        return $r; // Not a theme update request. Bail immediately.
    $themes = unserialize( $r['body']['themes'] );
    unset( $themes[ get_option( 'template' ) ] );
    unset( $themes[ get_option( 'stylesheet' ) ] );
    $r['body']['themes'] = serialize( $themes );
    return $r;
}
add_filter( 'http_request_args', 'afn_prevent_theme_update', 5, 2 );

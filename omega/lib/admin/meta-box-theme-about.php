<?php
/**
 * Creates a meta box for the theme settings page, which displays information about the theme.  If a child 
 * theme is in use, an additional meta box will be added with its information.  To use this feature, the theme 
 * must support the 'about' argument for 'omega-theme-settings' feature.
 */

/* Create the about theme meta box on the 'add_meta_boxes' hook. */
add_action( 'add_meta_boxes', 'omega_meta_box_theme_add_about' );

/**
 * Adds the core about theme meta box to the theme settings page.
 *
 * @since 0.9.1
 * @return void
 */
function omega_meta_box_theme_add_about() {

	/* Get theme information. */
	$theme = wp_get_theme( get_template(), get_theme_root( get_template_directory() ) );

	
	/* If the user is using a child theme, add an About box for it. */
	if ( is_child_theme() ) {
		$child = wp_get_theme( get_stylesheet(), get_theme_root( get_stylesheet_directory() ) );
		add_meta_box( 'omega-about-child', sprintf( __( 'About %s', 'omega' ), $child->get( 'Name' ) ), 'omega_meta_box_theme_display_about', omega_get_settings_page_name(), 'side', 'high' );
	} else {
		/* Adds the About box for the parent theme. */
		add_meta_box( 'omega-about-theme', sprintf( __( 'About %s', 'omega' ), $theme->get( 'Name' ) ), 'omega_meta_box_theme_display_about', omega_get_settings_page_name(), 'side', 'high' );	
	}
}

/**
 * Creates an information meta box with no settings about the theme. The meta box will display
 * information about both the parent theme and child theme. If a child theme is active, this function
 * will be called a second time.
 *
 * @since 0.9.1
 * @param object $object Variable passed through the do_meta_boxes() call.
 * @param array $box Specific information about the meta box being loaded.
 * @return void
 */
function omega_meta_box_theme_display_about( $object, $box ) {

	/* Get theme information. */

	/* Grab theme information for the parent/child theme. */
	$theme = ( 'omega-about-child' == $box['id'] ) ? wp_get_theme( get_stylesheet(), get_theme_root( get_stylesheet_directory() ) ) : wp_get_theme( get_template(), get_theme_root( get_template_directory() ) ); 
	if ( is_child_theme() ) {
		$parent = wp_get_theme( get_template(), get_theme_root( get_template_directory() ));
	}
	?>
	<table class="form-table">
		<tr>
			<th>
				<?php _e( 'Theme:', 'omega' ); ?>
			</th>
			<td>
				<a href="<?php echo esc_url( $theme->get( 'ThemeURI' ) ); ?>" title="<?php echo esc_attr( $theme->get( 'Name' ) ); ?>"><?php echo $theme->get( 'Name' ); ?></a>
			</td>
		</tr>
		<tr>
			<th>
				<?php _e( 'Version:', 'omega' ); ?>
			</th>
			<td>
				<?php echo $theme->get( 'Version' ); ?>
			</td>
		</tr>
		<tr>
			<th>
				<?php _e( 'Author:', 'omega' ); ?>
			</th>
			<td>
				<a href="<?php echo esc_url( $theme->get( 'AuthorURI' ) ); ?>" title="<?php echo esc_attr( $theme->get( 'Author' ) ); ?>"><?php echo $theme->get( 'Author' ); ?></a>
			</td>
		</tr>
		<tr>
			<th>
				<?php _e( 'Description:', 'omega' ); ?>
			</th>
			<td>
				<?php echo $theme->get( 'Description' ); ?>
			</td>
		</tr>
		<?php
		if ( isset($parent) ) {
		?>
		<tr>
			<th>
				<?php _e( 'Framework:', 'omega' ); ?>
			</th>
			<td>
				<a href="<?php echo esc_url( $parent->get( 'ThemeURI' ) ); ?>" title="<?php echo esc_attr( $parent->get( 'Name' ) ); ?>"><?php echo $parent->get( 'Name' ); ?></a> - 
				<?php  echo $parent->get( 'Description' ); ?>
			</td>
		</tr>	
		<?php
		}
		?>	
	</table><!-- .form-table --><?php
}

?>
<?php
/**
 * Creates a meta box for the theme settings page, which holds textareas for custom scripts within 
 * the theme. 
 *
 */

/* Create a settings meta box only on the theme settings page. */
add_action( 'add_meta_boxes', 'omega_theme_settings_scripts' );

/* Adds my_help_tab when my_admin_page loads */
add_action('load-'.omega_get_settings_page_name(), 'omega_theme_settings_scripts_help');


/**
 * Adds the core theme scripts meta box to the theme settings page in the admin.
 *
 * @since 0.3.0
 * @return void
 */
function omega_theme_settings_scripts() {

	add_meta_box(
		'omega-theme-scripts',			// Name/ID
		__( 'Header and Footer Scripts', 'omega' ),	// Label
		'omega_meta_box_theme_display_scripts',			// Callback function
		omega_get_settings_page_name(),		// Page to load on, leave as is
		'normal',					// Which meta box holder?
		'high'					// High/low within the meta box holder
	);

}

/**
 * Creates a meta box that allows users to customize their scripts.
 */
function omega_meta_box_theme_display_scripts() {
?>
	<p>
		<label for="<?php echo omega_settings_field_id( 'header_scripts' ); ?>"><?php printf( __( 'Insert scripts or code before the closing %s tag in the document source', 'omega' ), '<code>&lt;/head&gt;</code>' ); ?>:</label>
	</p>
	
	<textarea name="<?php echo omega_settings_field_name( 'header_scripts' ) ?>" id="<?php echo omega_settings_field_id( 'header_scripts' ); ?>" cols="78" rows="8"><?php echo omega_get_setting( 'header_scripts' ); ?></textarea>


	<p>
		<label for="<?php echo omega_settings_field_id( 'footer_scripts' ); ?>"><?php printf( __( 'Insert scripts or code before the closing %s tag in the document source', 'omega' ), '<code>&lt;/body&gt;</code>' ); ?>:</label>
	</p>

	<textarea name="<?php echo omega_settings_field_name( 'footer_scripts' ); ?>" id="<?php echo omega_settings_field_id( 'footer_scripts' ); ?>" cols="78" rows="8"><?php echo omega_get_setting( 'footer_scripts' ) ; ?></textarea>


<?php }


/**
 * Contextual help content.
 */
function omega_theme_settings_scripts_help() {

	$screen = get_current_screen();

	$scripts_help =
		'<h3>' . __( 'Header and Footer Scripts', 'omega' ) . '</h3>' .
		'<p>'  . __( 'This provides you with two fields that will output to the head section of your site and just before the closing body tag. These will appear on every page of the site and are a great way to add analytic code, Google Font and other scripts. You cannot use PHP in these fields.', 'omega' ) . '</p>';
			
	$screen->add_help_tab( array(
		'id'      => 'omega-settings' . '-scripts',
		'title'   => __( 'Header and Footer Scripts', 'omega' ),
		'content' => $scripts_help,
	) );

}

?>
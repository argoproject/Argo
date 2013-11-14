<?php

/**
 * Register our sidebars and other widget areas
 *
 * @todo move the taxonomy landing page sidebar registration here
 *  (currently in inc/wp-taxonomy-landing/functions/cftl-admin.php)
 * @since 1.0
 */
function largo_register_sidebars() {
	$sidebars = array (
		// the default widget areas
		array (
			'name'	=> __( 'Main Sidebar', 'largo' ),
			'desc' 	=> __( 'The sidebar for the homepage. If you do not add widgets to any of the other sidebars, this will also be used on all of the other pages of your site.', 'largo' ),
			'id' 	=> 'sidebar-main'
		),
		array (
			'name' 	=> __( 'Single Sidebar', 'largo' ),
			'desc' 	=> __( 'The sidebar for posts and pages', 'largo' ),
			'id' 	=> 'sidebar-single'
		),
		array (
			'name' 	=> __( 'Footer 1', 'largo' ),
			'desc' 	=> __( 'The first footer widget area.', 'largo' ),
			'id' 	=> 'footer-1'
		),
		array (
			'name' 	=> __( 'Footer 2', 'largo' ),
			'desc' 	=> __( 'The second footer widget area.', 'largo' ),
			'id' 	=> 'footer-2'
		),
		array(
			'name' 	=> __( 'Footer 3', 'largo' ),
			'desc' 	=> __( 'The third footer widget area.', 'largo' ),
			'id' 	=> 'footer-3'
		)
	);

	// optional widget areas
	if ( of_get_option( 'use_topic_sidebar' ) ) {
		$sidebars[] = array(
			'name' 	=> __( 'Archive/Topic Sidebar', 'largo' ),
			'desc' 	=> __( 'The sidebar for category, tag and other archive pages', 'largo' ),
			'id' 	=> 'topic-sidebar'
		);
	}
	if ( of_get_option('footer_layout') == '4col' ) {
		$sidebars[] = array(
			'name' 	=> __( 'Footer 4', 'largo' ),
			'desc' 	=> __( 'The fourth footer widget area.', 'largo' ),
			'id' 	=> 'footer-4'
		);
	}
	if ( of_get_option('homepage_layout') == '3col' ) {
		$sidebars[] = array(
			'name' 	=> __( 'Homepage Left Rail', 'largo' ),
			'desc' 	=> __( 'An optional widget area that, when enabled, appears to the left of the main content area on the homepage.', 'largo' ),
			'id' 	=> 'homepage-left-rail'
		);
	}
	if ( of_get_option('homepage_bottom') == 'widgets' ) {
		$sidebars[] = array(
			'name' 	=> __( 'Homepage Bottom', 'largo' ),
			'desc' 	=> __( 'An optional widget area at the bottom of the homepage', 'largo' ),
			'id' 	=> 'homepage-bottom'
		);
	}

	// @todo - probably add an option to enable this because not everyone is going to have ads here
	// @todo - add additional widget area in the footer for a leaderboard ad unit there too
	$sidebars[] = array(
		'name' 	=> __( 'Header Ad Zone', 'largo'),
		'desc' 	=> __( 'An optional leaderboard ad zone above the main site header', 'largo' ),
		'id' 	=> 'header-ads'
	);

	// user-defined custom widget areas
	$custom_sidebars = preg_split( '/$\R?^/m', of_get_option( 'custom_sidebars' ) );
	if ( is_array( $custom_sidebars ) ) {
		foreach( $custom_sidebars as $sidebar ) {
			$sidebar_slug = largo_make_slug( $sidebar );
			if ( $sidebar_slug ) {
				$sidebars[] = array(
					'name' 	=> __( $sidebar, 'largo' ),
					'desc' 	=> '',
					'id' 	=> $sidebar_slug
				);
			}
		}
	}

	// register the active widget areas
	foreach ( $sidebars as $sidebar ) {
		register_sidebar( array(
			'name' 			=> $sidebar['name'],
			'description' 	=> $sidebar['desc'],
			'id' 			=> $sidebar['id'],
			'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
			'after_widget' 	=> "</aside>",
			'before_title' 	=> '<h3 class="widgettitle">',
			'after_title' 	=> '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'largo_register_sidebars' );

/**
 * Helper function to transform user-entered text into WP-compatible slugs
 *
 * @since 1.0
 */
function largo_make_slug($string, $maxLength = 63) {
  $result = preg_replace("/[^a-z0-9\s-]/", "", strtolower($string));
  $result = trim(preg_replace("/[\s-]+/", " ", $result));
  $result = trim(substr($result, 0, $maxLength));
  return preg_replace("/\s/", "-", $result);
}

/**
 * Builds a dropdown menu of the custom sidebars
 * Used in the meta box on post/page edit screen
 *
 * @since 1.0
 */
if( !function_exists( 'custom_sidebars_dropdown' ) ) {
	function custom_sidebars_dropdown() {
		global $wp_registered_sidebars, $post;
		$custom = get_post_meta( $post->ID, 'custom_sidebar', true );
		$val = ( $custom ) ? $custom : 'none';

		// Add a default option
		$output .= '<option';
		if( $val == 'default' ) $output .= ' selected="selected"';
		$output .= ' value="default">' . __( 'Default', 'largo' ) . '</option>';

		// Build an array of sidebars, making sure they're real
	  	$custom_sidebars = preg_split( '/$\R?^/m', of_get_option( 'custom_sidebars' ) );
		$sidebar_slugs = array_map( 'largo_make_slug', $custom_sidebars );

		// Fill the select element with all registered sidebars that are custom
		foreach( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
			if ( !in_array( $sidebar_id, $sidebar_slugs ) ) continue;
			$output .= '<option';
			if ( $sidebar_id == $val ) $output .= ' selected="selected"';
			$output .= ' value="' . $sidebar_id . '">' . $sidebar['name'] . '</option>';
		}

		$output .= '</select>';
		echo $output;
	}
}

/**
 * Render the widget setting fields on the widget page
 */
function largo_widget_settings() {
	?>
	<div class="wrap">
		<div class="advance-widget-settings">
			<div id="optionsframework-metabox" class="metabox-holder">
			    <div id="optionsframework" class="postbox">
					<form action="options.php" method="post">
						<div> <?php // Extra open <div> because optinosframework_fields() adds an extra closing </div> ?>
					<?php settings_fields('optionsframework'); ?>
					<?php optionsframework_fields(); /* Settings */ ?>
					<div id="optionsframework-submit">
						<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( 'Save Options', 'options_framework_theme' ); ?>" />
						<input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults', 'options_framework_theme' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Click OK to reset. Any theme settings will be lost!', 'options_framework_theme' ) ); ?>' );" />
						<br class="clear" />
					</div>
					</form>
				</div>
			</div>
		</div>
		<br class="clear" />
	</div>
	<br class="clear" />
	<?php
}
add_action( 'sidebar_admin_page', 'largo_widget_settings' );

/**
 * Load up the scripts for options framework on the widgets
 */
function largo_load_of_script_for_widget( $hook ) {
	
	if ( $hook == 'widgets.php' ) {
		optionsframework_load_scripts( 'appearance_page_options-framework' );
		optionsframework_load_styles();
		wp_enqueue_style( 'largo-widgets-php', get_template_directory_uri() . '/css/widgets-php.css');
	}
}
add_action('admin_enqueue_scripts', 'largo_load_of_script_for_widget');


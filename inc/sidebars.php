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
	if ( of_get_option( 'leaderboard_enabled' ) ) {
		$sidebars[] = array(
	 		'name' 	=> __( 'Header Ad Zone', 'largo'),
	 		'desc' 	=> __( 'An optional leaderboard (728x90) ad zone above the main site header', 'largo' ),
	 		'id' 	=> 'header-ad'
	 	);
	 }

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
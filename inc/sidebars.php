<?php

/*
 * SIDEBAR REGISTRATION
 */
function largo_register_sidebars() {
	register_sidebar( array(
		'name' 			=> __( 'Main Sidebar', 'largo' ),
		'description' 	=> __( 'The sidebar for index and archive pages', 'largo' ),
		'id' 			=> 'sidebar-main',
		'before_widget' => '<aside id="%1$s" class="%2$s odd_even clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Single Sidebar', 'largo' ),
		'description' 	=> __( 'The sidebar for posts and pages', 'largo' ),
		'id' 			=> 'sidebar-single',
		'before_widget' => '<aside id="%1$s" class="%2$s odd_even clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Topic Sidebar', 'largo' ),
		'description' 	=> __( 'The sidebar for category and tag pages', 'largo' ),
		'id' 			=> 'topic-sidebar',
		'before_widget' => '<aside id="%1$s" class="%2$s odd_even clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Footer Featured Posts', 'largo' ),
		'description' 	=> __( 'Center footer column.', 'largo' ),
		'id' 			=> 'footer-featured-posts',
		'before_widget' => '<aside id="%1$s" class="%2$s odd_even clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Footer Widget Area', 'largo' ),
		'description' 	=> __( 'A configurable widget area in the far right column of the site footer.', 'largo' ),
		'id' 			=> 'footer-widget-area',
		'before_widget' => '<aside id="%1$s" class="%2$s odd_even clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

	if ( of_get_option('homepage_bottom') == 'widgets' ) :
		register_sidebar( array(
			'name' 			=> __( 'Homepage Bottom', 'largo' ),
			'description' 	=> __( 'An optional widget area at the bottom of the homepage', 'largo' ),
			'id' 			=> 'homepage-bottom',
			'before_widget' => '<div id="%1$s" class="%2$s odd_even span6">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h3 class="widgettitle">',
			'after_title' 	=> '</h3>',
		) );
	endif;
}
add_action( 'widgets_init', 'largo_register_sidebars' );
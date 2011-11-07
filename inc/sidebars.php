<?php

/*
 * SIDEBAR REGISTRATION
 */
function argo_register_sidebars() {

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'argo' ),
		'id' => 'sidebar-main',
		'description' => __( 'The sidebar for index and archive pages', 'argo' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Single Sidebar', 'argo' ),
		'id' => 'sidebar-single',
		'description' => __( 'The sidebar for posts and pages', 'argo' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Topic Sidebar', 'argo' ),
		'id' => 'topic-sidebar',
		'description' => __( 'The sidebar for category and tag pages', 'argo' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'argo' ),
		'id' => 'footer-1',
		'description' => __( 'a 2 column footer region', 'argo' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'argo' ),
		'id' => 'footer-2',
		'description' => __( 'a 6 column footer region', 'argo' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'argo' ),
		'id' => 'footer-3',
		'description' => __( 'a 4 column footer region', 'argo' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'init', 'argo_register_sidebars' );
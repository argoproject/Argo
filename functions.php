<?php
/**
 * Largo functions and definitions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'eleven_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 771;

// load the options framework (used for our theme options pages)
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/options-framework/' );
	require_once dirname( __FILE__ ) . '/inc/options-framework/options-framework.php';
}

/**
 * Load up all of the other goodies in the /inc directory
 */

// a list of recommended plugins
require_once( get_template_directory() . '/inc/largo-plugin-init.php' );

// header cleanup and robots.txt
require_once( get_template_directory() . '/inc/special-functionality.php' );

// add custom fields for user profiles
require_once( get_template_directory() . '/inc/users.php' );

// register sidebars, widgets and nav menus
require_once( get_template_directory() . '/inc/sidebars.php' );
require_once( get_template_directory() . '/inc/widgets.php' );
require_once( get_template_directory() . '/inc/nav-menus.php' );

// add our custom taxonomies
require_once( get_template_directory() . '/inc/taxonomies.php' );

// setup custom image sizes
require_once( get_template_directory() . '/inc/images.php' );

// add tinymce customizations and shortcodes
require_once( get_template_directory() . '/inc/editor.php' );

// add post meta boxes
require_once( get_template_directory() . '/inc/post-meta.php' );

// add open graph, twittercard and google publisher markup to the header
require_once( get_template_directory() . '/inc/open-graph.php' );

// add some custom template tags (mostly used in single posts)
require_once( get_template_directory() . '/inc/post-tags.php' );

// some additional template tags used in the header and footer
require_once( get_template_directory() . '/inc/header-footer.php' );

// some functions dealing with related and featured content
require_once( get_template_directory() . '/inc/related-content.php' );
require_once( get_template_directory() . '/inc/featured-content.php' );

// enqueue our js and css files
require_once( get_template_directory() . '/inc/enqueue.php' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override largo_setup() in a child theme, add your own largo_setup() to your child theme's
 * functions.php file.
 */
if ( ! function_exists( 'largo_setup' ) ) {

	function largo_setup() {

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style('/css/editor-style.css');

		// Add default posts and comments RSS feed links to <head>.
		add_theme_support( 'automatic-feed-links' );

		// Add support for localization (this is a work in progress)
		load_theme_textdomain('largo', get_template_directory() . '/lang');

	}
}
add_action( 'after_setup_theme', 'largo_setup' );
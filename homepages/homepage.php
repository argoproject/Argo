<?php

/**
 * Registers all of the standard Largo homepage layout classes
 */
function largo_register_default_homepage_layouts() {
	include_once __DIR__ . '/functions.php';

	// Load layouts from `layouts/`
	$layouts = glob(__DIR__ . '/layouts/*.php');
	foreach ($layouts as $layout)
		include_once $layout;

	// Load zone components from `zones/`
	$zones = glob(__DIR__ . '/zones/*.php');
	foreach ($zones as $zone)
		include_once $zone;

	$default_layouts = array(
		'HomepageBlog',
		'HomepageSingle',
		'HomepageSingleWithFeatured',
		'HomepageSingleWithSeriesStories',
		'HomepageTwoPanel',
		'HomepageThreePanel',
		'TopStories',
		'Slider'
	);

	foreach ($default_layouts as $layout)
		register_homepage_layout($layout);
}
add_action('init', 'largo_register_default_homepage_layouts', 0);

/**
 * Uses `$largo_homepage_factory` to build a list of homepage layouts.This list is used
 * in Theme Options and Customizer to allow the user to choose a Homepage layout.
 *
 * @return array An array of layouts, with friendly names as keys and arrays with 'path' and 'thumb' as values
 */
if (!function_exists('largo_get_home_layouts')) {

	function largo_get_home_layouts() {
		global $largo_homepage_factory;

		$cache_key = 'largo_home_layouts_' . get_option( 'stylesheet' );
		if ( false !== ( $layouts = get_transient( $cache_key ) ) ) {
			return $layouts;
		}

		$layouts = array();
		foreach ($largo_homepage_factory->layouts as $className => $layout) {
			$layouts[trim($layout->name)] = array(
				'path' => $className,
				'thumb' => largo_get_home_thumb($className),
				'desc' => $layout->description
			);
		}

		set_transient( $cache_key, $layouts, HOUR_IN_SECONDS );
		return $layouts;
	}
}

/**
 * Retrieves the thumbnail image for a homepage template, or a default
 *
 * @return string The public url of the image file to use for the given template's screenshot
 */
function largo_get_home_thumb($className) {
	if (file_exists(get_template_directory() . '/homepages/assets/img/' . $className . '.png'))
		return get_template_directory_uri() . '/homepages/assets/img/' . $className . '.png';
	return get_template_directory_uri() . '/homepages/assets/img/no-thumb.png';
}

/**
 * Creates instance of a homepage layout class and renders it.
 */
function largo_render_homepage_layout($layout) {
	$hp = new $layout();
	$hp->render();
}

/**
 * Get the class name of the currently-active homepage layout
 */
function largo_get_active_homepage_layout() {
	return str_replace('.php', '', of_get_option('home_template', 'Blog.php'));
}

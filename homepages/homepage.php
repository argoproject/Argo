<?php

function var_log($stuff) {
	error_log(var_export($stuff, true));
}

function register_default_layouts() {
	largo_load_custom_template_functions();

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
		'HomepageBigStoryWithSeries',
		'HomepageBigStoryWithSeriesAndFeatured'
	);

	foreach ($default_layouts as $layout)
		register_homepage_layout($layout);
}
add_action('init', 'register_default_layouts', 0);

function render_homepage_layout($layout) {
	$hp = new $layout();
	$hp->render();
}

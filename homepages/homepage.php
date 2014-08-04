<?php

function var_log($stuff) {
	error_log(var_export($stuff, true));
}

function register_default_layouts() {
	largo_load_custom_template_functions();

	$default_layouts = array(
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

include_once __DIR__ . '/homepage-class.php';

$layouts = glob(__DIR__ . '/layouts/*.php');
foreach ($layouts as $layout)
	include_once $layout;

include_once __DIR__ . '/zones.php';

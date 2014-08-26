<?php

include_once dirname(__DIR__) . '/homepage-class.php';

class Slider extends Homepage {
	var $name = 'Slider';
	var $type = 'slider';
	var $description = 'An animated carousel of featured stories with large images. Not recommended but available for backward compatibility.';
	var $sidebars = array(
		'Homepage Left Rail (An optional widget area that, when enabled, appears to the left of the main content area on the homepage)'
	);
	var $rightRail = true;

	function __construct($options=array()) {
		$defaults = array(
			'template' => get_template_directory() . '/homepages/templates/slider.php',
			'assets' => array(
				array('homepage-slider', get_template_directory_uri() . '/homepages/assets/css/slider.css', array()),
				array('homepage-slider', get_template_directory_uri() . '/homepages/assets/js/slider.js', array('jquery'))
			)
		);
		$options = array_merge($defaults, $options);
		$this->init($options);
		$this->load($options);
	}

	public function init($options=array()) {
		$this->prominenceTerms = array(
			array(
				'name' => __('Homepage Top Story', 'largo'),
				'description' => __('If you are using the Newspaper or Carousel optional homepage layout, add this label to a post to make it the top story on the homepage', 'largo'),
				'slug' => 'top-story'
			),
			array(
				'name' => __('Homepage Featured', 'largo'),
				'description' => __('Add this label to posts to display them in the featured area on the homepage.', 'largo'),
				'slug' => 'homepage-featured'
			)
		);
	}
}

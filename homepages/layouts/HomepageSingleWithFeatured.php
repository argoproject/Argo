<?php

include_once __DIR__ . '/HomepageSingle.php';

class HomepageSingleWithFeatured extends HomepageSingle {
	var $name = 'One big story and list of featured stories';
	var $type = 'featured';
	var $description = 'A single story with full-width image treatment. Featured stories appear to the right of the big story\'s headline and excerpt.';
	var $sidebars = array(
		'Home Bottom Left', 'Home Bottom Center', 'Home Bottom Right'
	);

	function __construct($options=array()) {
		$this->prominenceTerms = array(
			array(
				'name' => __('Homepage Featured', 'largo'),
				'description' => __('If you are using the Newspaper or Carousel optional homepage layout, add this label to posts to display them in the featured area on the homepage.', 'largo'),
				'slug' => 'homepage-featured'
			),
			array(
				'name' => __('Featured in Series', 'largo'),
				'description' => __('Select this option to allow this post to float to the top of any/all series landing pages sorting by Featured first.', 'largo'),
				'slug' => 'series-featured'
			),
			array(
				'name' => __('Featured in Category', 'largo'),
				'description' => __('This will allow you to designate a story to appear more prominently on category archive pages.', 'largo'),
				'slug' => 'category-featured'
			)
		);

		$defaults = array(
			'template' => get_template_directory() . '/homepages/templates/full-width-image.php',
			'assets' => array(
				array('homepage-single', get_template_directory_uri() . '/homepages/assets/css/single.css', array()),
				array('homepage-single', get_template_directory_uri() . '/homepages/assets/js/single.js', array('jquery'))
			)
		);
		$options = array_merge($defaults, $options);
		$this->load($options);
	}

	public function moreStories() {
		return homepage_feature_stories_list();
	}
}

<?php

include_once __DIR__ . '/HomepageSingle.php';

class HomepageBigStoryWithSeriesAndFeatured extends HomepageSingle {
	var $name = 'Three panel homepage layout';
	var $type = 'three-panel';
	var $description = 'Three panel homepage with one big story, stories from the series and finally, featured stories.';

	function __construct($options=array()) {
		$defaults = array(
			'template' => get_template_directory() . '/homepages/templates/three-panel.php',
			'assets' => array(
				array('homepage-three-panel', get_template_directory_uri() . '/homepages/assets/css/hero-series-side.css', array()),
				array('homepage-three-panel', get_template_directory_uri() . '/homepages/assets/js/hero-series-side.js', array('jquery'))
			)
		);
		$options = array_merge($defaults, $options);
		$this->load($options);
	}

	public function bigStory() {
		return homepage_big_story_headline_small();
	}
}

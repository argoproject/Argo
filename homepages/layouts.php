<?php

class HomepageSingle extends Homepage {
	var $name = 'Big story, full-width image';
	var $description = 'A single story with full-width image treatment. Includes a headline and excerpt.';

	function __construct($options=array()) {
		$defaults = array(
			'template' => get_template_directory() . '/homepages/templates/full-width-image.php',
			'assets' => array(
				array('homepage-single', get_template_directory_uri() . '/homepages/css/single.css', array(), null, true),
				array('homepage-single', get_template_directory_uri() . '/homepages/js/single.js', array('jquery'), null, true)
			)
		);
		$options = array_merge($defaults, $options);
		$this->load($options);
	}

	public function zoneOne() {
		return homepage_view_toggle();
	}
}

class HomepageSingleWithFeatured extends HomepageSingle {
	var $name = 'One big story and list of featured stories';
	var $description = 'A single story with full-width image treatment. Featured stories appear to the right of the big story\'s headline and excerpt.';

	public function zoneTwo() {
		return homepage_big_story_headline();
	}
}

<?php

class HomepageSingle extends Homepage {
	var $name = 'Big story, full-width image';
	var $type = 'single';
	var $description = 'A single story with full-width image treatment. Includes a headline and excerpt.';

	function __construct($options=array()) {
		$defaults = array(
			'template' => get_template_directory() . '/homepages/templates/full-width-image.php',
			'assets' => array(
				array('homepage-single', get_template_directory_uri() . '/homepages/css/single.css', array()),
				array('homepage-single', get_template_directory_uri() . '/homepages/js/single.js', array('jquery'))
			)
		);
		$options = array_merge($defaults, $options);
		$this->load($options);
	}

	public function viewToggle() {
		return homepage_view_toggle();
	}

	public function bigStory() {
		return homepage_big_story_headline();
	}
}

class HomepageSingleWithFeatured extends HomepageSingle {
	var $name = 'One big story and list of featured stories';
	var $type = 'featured';
	var $description = 'A single story with full-width image treatment. Featured stories appear to the right of the big story\'s headline and excerpt.';

	public function moreStories() {
		return homepage_feature_stories_list();
	}
}

class HomepageSingleWithSeriesStories extends HomepageSingle {
	var $name = 'One big story and list of stories from the same series';
	var $type = 'series';
	var $description = 'A single story with full-width image treatment. Series stories appear to the right of the big story\'s headline and excerpt.';

	public function moreStories() {
		return homepage_series_stories_list();
	}
}

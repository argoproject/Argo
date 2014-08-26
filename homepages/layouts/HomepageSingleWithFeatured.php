<?php

include_once __DIR__ . '/HomepageSingle.php';

class HomepageSingleWithFeatured extends HomepageSingle {
	var $name = 'One big story and list of featured stories';
	var $type = 'featured';
	var $description = 'A single story with full-width image treatment. Featured stories appear to the right of the big story\'s headline and excerpt.';
	var $sidebars = array(
		'Home Bottom Left', 'Home Bottom Center', 'Home Bottom Right'
	);

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

	public function moreStories() {
		return homepage_feature_stories_list();
	}
}

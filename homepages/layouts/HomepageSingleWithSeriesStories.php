<?php

include_once __DIR__ . '/HomepageSingle.php';

class HomepageSingleWithSeriesStories extends HomepageSingle {

	/**
	 * If the Series taxonomy is not enabled, this class should unregister itself.
	 *
	 * The default homepage layouts are listed in homepages/homepage.php.
	 * For each default layout, register_homepage_layout is called on that layout class.
	 * register_homepage_layout calls the HomepageLayoutFactory method register on that class instance
	 * the register method creates a new instance of that class
	 * therefore the __construct method here checks largo_is_series_enabled 
	 */
	function __construct($options=array()) {
		if ( !largo_is_series_enabled() ){
			
			global $largo_homepage_factory;
			
			$layoutClass = get_class($this);
			var_log($layoutClass);
			var_log($largo_homepage_factory->layouts);
			var_log($largo_homepage_factory->layouts[$layoutClass]);
			// Read the logs. This object hasn't been created yet, so it can't be removed from within the constructor.
			
			unset($largo_homepage_factory->layouts[get_class($this)]);
			unset($this);
			unregister_homepage_layout(get_class($this));
		} else {
			$defaults = array(
				'name' => __('One big story and list of stories from the same series', 'largo'),
				'type' => 'series',
				'description' => __('A single story with full-width image treatment. Series stories appear to the right of the big story\'s headline and excerpt.', 'largo'),
				'sidebars' => array(
					__('Home Bottom Left', 'largo'), __('Home Bottom Center', 'largo'), __('Home Bottom Right', 'largo')
				),
				'prominenceTerms' => array(
					array(
						'name' => __('Homepage Top Story', 'largo'),
						'description' => __('If you are using the Newspaper or Carousel optional homepage layout, add this label to a post to make it the top story on the homepage', 'largo'),
						'slug' => 'top-story'
					)
				)
			);
			$options = array_merge($defaults, $options);
			parent::__construct($options);
		}
	}

	public function moreStories() {
		return homepage_series_stories_list();
	}
}

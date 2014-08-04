<?php

include_once __DIR__ . '/homepage-single.php';

class HomepageBigStoryWithSeries extends HomepageSingle {
	var $name = 'Two panel homepage layout';
	var $type = 'two-panel';
	var $description = 'Two panel homepage with one big story and stories.';

	function __construct($options=array()) {
		$defaults = array(
			'template' => get_template_directory() . '/homepages/templates/two-panel.php',
			'assets' => array(
				array('homepage-single', get_template_directory_uri() . '/homepages/assets/css/hero-series-side.css', array()),
				array('homepage-single', get_template_directory_uri() . '/homepages/assets/js/hero-series-side.js', array('jquery'))
			)
		);
		$options = array_merge($defaults, $options);
		$this->load($options);
	}
}

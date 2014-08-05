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
		$defaults = array('template' => get_template_directory() . '/homepages/templates/slider.php');
		$options = array_merge($defaults, $options);
		$this->load($options);
	}
}

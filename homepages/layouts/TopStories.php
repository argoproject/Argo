<?php

include_once dirname(__DIR__) . '/homepage-class.php';

class TopStories extends Homepage {
	var $name = 'Top Stories';
	var $type = 'top-stories';
	var $description = 'A newspaper-like layout highlighting one Top Story on the left and others to the right. A popular layout choice!';

	function __construct($options=array()) {
		$defaults = array('template' => get_template_directory() . '/homepages/templates/top-stories.php');
		$options = array_merge($defaults, $options);
		$this->load($options);
	}
}

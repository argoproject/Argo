<?php

include_once dirname(__DIR__) . '/homepage-class.php';

class HomepageBlog extends Homepage {
	var $name = 'Blog';
	var $description = 'A blog-like list of posts with the ability to stick a post to the top of the homepage. Be sure to set Homepage Bottom to the single column view.';
	var $rightRail = true;

	function __construct($options=array()) {
		$defaults = array('template' => get_template_directory() . '/homepages/templates/blog.php');
		$options = array_merge($defaults, $options);
		$this->load($options);
	}
}

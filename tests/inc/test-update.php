<?php

class UpdateTestFunctions extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();
		of_reset_options();
#		$this->term_id = $this->factory->term->create( array(
#			'name' => 'Prominence',
#			'taxonomy' => 'prominence',
#			'slug' => 'term-slug'
#		));
		$this->term_ids = $this->factory->term->create_many( 10, array(
			'taxonomy' => 'prominence'
		));
	}
	function test_largo_version() {
		// depends upon wp_get_theme,
		//   depends upon get_stylesheet
		//   depends upon get_raw_theme_root
		// var_dump($GLOBALS['wp_theme_directories']); does return useful info
		
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_need_updates() {
		// requires largo_version
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	
	function test_largo_perform_update() {
		// requires largo_need_updates
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_home_transition() {
		// old topstories
		of_reset_options();
		of_set_option('homepage_top', 'topstories');
		largo_home_transition();
		$this->assertEquals('TopStories', of_get_option('home_template', 0));
		
		// old slider
		of_reset_options();
		of_set_option('homepage_top', 'slider');
		largo_home_transition();
		$this->assertEquals('HomepageBlog', of_get_option('home_template', 0));
		
		// old blog
		of_reset_options();
		of_set_option('homepage_top', 'blog');
		largo_home_transition();
		$this->assertEquals('HomepageBlog', of_get_option('home_template', 0));
		
		// Anything else
		of_reset_options();
		of_set_option('', 'slider');
		largo_home_transition();
		$this->assertEquals('HomepageBlog', of_get_option('home_template', 0));
		
		// Not actually set
		of_reset_options();
		largo_home_transition();
		$this->assertEquals('HomepageBlog', of_get_option('home_template', 0));
	}
	function test_largo_update_widgets() {
		// uses largo_widget_in_region
		// uses largo_instantiate_widget
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_widget_in_region() {
		// uses WP_Error
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_instantiate_widget() {
		// uses wp_parse_args, available here
		// uses update_option, available here
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_check_deprecated_widgets() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_deprecated_footer_widget() {
		// prints a nag
		// uses __
		$this->expectOutputRegex('/[.*]+/'); // This is excessively greedy, it expects any output at all
		largo_deprecated_footer_widget();
	}
	function test_largo_deprecated_sidebar_widget() {
		// prints a nag
		// uses __
		$this->expectOutputRegex('/[.*]+/'); // This is excessively greedy, it expects any output at all
		largo_deprecated_sidebar_widget();
	}
	function test_largo_transition_nav_menus() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_update_prominence_term_descriptions() {

		largo_update_prominence_term_descriptions();
		$terms = get_terms('prominence', array(
			'hide_empty' => false,
			'fields' => 'all'
		));

#		var_log(json_decode(json_encode($terms)));
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
}

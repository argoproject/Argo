<?php
/*
class MockWP_Theme {


	function get($value) {
		return $this->$value;
	}
}
*/

class UpdateTestFunctions extends WP_UnitTestCase {

	function setUp() {
		of_reset_options();
		parent::setUp();
	}

	function wp_get_theme() {
		return true;
	}

	function test_largo_version() {
		// depends upon wp_get_theme,
		//   depends upon get_stylesheet
		//   depends upon get_raw_theme_root, which does exist here
#		var_dump($GLOBALS['wp_theme_directories']);
		
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
		
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_update_widgets() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_widget_in_region() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_instantiate_widget() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_check_deprecated_widgets() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_deprecated_footer_widget() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_deprecated_sidebar_widget() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_transition_nav_menus() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

}

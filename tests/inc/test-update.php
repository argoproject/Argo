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

		of_set_option('social_icons_display', 'both');
		//test
		
		of_set_option('social_icons_display', 'btm');
		//test
		
		of_set_option('show_tags', array(1));
		of_set_option('show_author_box', array('1'));
		of_set_option('show_related_content', array('1'));
		of_set_option('show_next_prev_nav_single', array('1'));
		
		$this->markTestIncomplete('This test has not been implemented yet.');
		of_reset_options();
	}
	function test_largo_widget_in_region() {
		// uses WP_Error
		$widgets_backup = get_option( 'sidebars_widgets ');

		// A widget that exists in a sidebar that does
		update_option( 'sidebars_widgets', array(
			'sidebar-single' => array (
				0 => 'archives-2',
			),
		) );
		$return = largo_widget_in_region('archives', 'sidebar-single');
		$this->assertTrue($return);
		unset($return);

		// A widget that does not exist in a sidebar that does
		update_option( 'sidebars_widgets', array(
			'sidebar-single' => array (
				0 => 'archives-2',
			),
		) );
		$return = largo_widget_in_region('wodget', 'sidebar-single');
		$this->assertFalse($return);
		unset($return);

		// A widget that exists in a sidebar that does not
		update_option( 'sidebars_widgets', array(
			'sidebar-single' => array (
				0 => 'archives-2',
			),
		) );
		$return = largo_widget_in_region('archives', 'missing-region');
		$this->assertTrue($return instanceof WP_Error);
		unset($return);

		// A widget that does not exist in a sidebar that also does not
		update_option( 'sidebars_widgets', array(
			'sidebar-single' => array (
				0 => 'archives-2',
			),
		) );
		$return = largo_widget_in_region('wodget', 'missing-region');
		$this->assertTrue($return instanceof WP_Error);
		unset($return);

		delete_option('sidebars_widgets');
		update_option('sidebars_widgets', $widgets_backup);
		unset($widgets_backup);
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
	function test_largo_update_prominence_term_description_single() {
		$update = array(
			'name' => 'Term 9',
			'description' => 'Term 9 From Outer Space',
			'olddescription' => 'Term Description 9',
			'slug' => 'term-9'
		);
		$term_descriptions = array('Term Description 9');

		$return = largo_update_prominence_term_description_single($update, $term_descriptions);
		$this->assertTrue(is_array($return));

		$term9 = get_term_by( 'slug', 'term-9', 'prominence', 'ARRAY_A' );
		$this->assertEquals('Term 9 From Outer Space', $term9['description']);
	}
	function test_largo_update_prominence_term_descriptions() {

		largo_update_prominence_term_descriptions();
		$terms = get_terms('prominence', array(
			'hide_empty' => false,
			'fields' => 'all'
		));

		$this->markTestIncomplete('This test has not been implemented yet.');
	}
}

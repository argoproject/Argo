<?php

class AjaxFunctionsTestFunctions extends WP_UnitTestCase {	

	function setUp() {
		parent::setUp();

		// Test data
		$this->post_count = 10;
		$this->post_ids = $this->factory->post->create_many($this->post_count);
	}

	function test_largo_load_more_posts_enqueue_script() {
		global $wp_scripts;
		largo_load_more_posts_enqueue_script();
		$this->assertTrue(!empty($wp_scripts->registered['load-more-posts']));
	}

	function test_largo_load_more_posts_data() {
		// create $shown_ids
		global $wp_scripts, $wp_query, $shown_ids;
		$args = array(
			'post_type' => 'post',
		);
		$wp_query = new WP_Query($args);
		if ($wp_query->have_posts()) {
			while ($wp_query->have_posts()) {
				$wp_query->the_post();
				$shown_ids[] = get_the_ID();
			}
		}

		largo_load_more_posts_data();

		// Obtain the registered scripts
		ob_start();
		$wp_scripts->print_scripts();
		$scripts = ob_get_contents();
		ob_end_clean();

		// Checking that the $shown_ids are in the LMP var with strpos
		foreach ($shown_ids as $k => $v ) {
			// strval($v) because bare numbers are interpreted as the index of a character
			$this->assertGreaterThan( 0, strpos($scripts, strval($v))); 
		}
	}

}

class AjaxFunctionsTestAjaxFunctions extends WP_Ajax_UnitTestCase {

	function setUp() {
		parent::setUp();

		// Test data
		$this->post_count = 10;
		$this->post_ids = $this->factory->post->create_many($this->post_count);
	}

	function test_largo_load_more_posts() {
		$_POST['paged'] = 0;
		$_POST['query'] = array();

		try {
			$this->_handleAjax("load_more_posts");
		} catch (WPAjaxDieContinueException $e) {
			foreach ($this->post_ids as $number) {
				$pos = strpos($this->_last_response, 'post-' . $number);
				$this->assertTrue((bool) $pos);
			}
		}
	}

	function test_largo_load_more_posts_empty_query() {
		$_POST['paged'] = 0;

		try {
			$this->_handleAjax("load_more_posts");
		} catch (WPAjaxDieContinueException $e) {
			foreach ($this->post_ids as $number) {
				$pos = strpos($this->_last_response, 'post-' . $number);
				$this->assertTrue((bool) $pos);
			}
		}
	}

}

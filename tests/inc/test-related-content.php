<?php

// Test functions in inc/related-content.php

class RelatedContentTestFunctions extends wp_UnitTestCase{
	function setUp() {
		parent::setUp();
	}

	function test_largo_get_related_topics_for_category() {
		$this->markTestIncomplete('This test has not been implemented yet.');

	}

	function test__tags_associated_with_category() {
		$this->markTestIncomplete('This test has not been implemented yet.');

	}

	function test__subcategories_for_category() {
		$this->markTestIncomplete('This test has not been implemented yet.');

	}

	function test_largo_get_post_related_topics() {
		$this->markTestIncomplete('This test has not been implemented yet.');

	}

	function test_largo_get_recent_posts_for_term() {
		$this->markTestIncomplete('This test has not been implemented yet.');

	}

	function test_largo_has_categories_or_tags() {
		$this->markTestIncomplete('This test has not been implemented yet.');

	}

	function test_largo_categories_and_tags() {
		$this->markTestIncomplete('This test has not been implemented yet.');

	}

	function test_largo_top_term() {
		$this->markTestIncomplete('This test has not been implemented yet.');

	}

	function test_largo_filter_get_post_related_topics() {
		$this->markTestIncomplete('This test has not been implemented yet.');

	}

	function test_largo_filter_get_recent_posts_for_term_query_args() {
		$this->markTestIncomplete('This test has not been implemented yet.');

	}

}

class LargoRelatedTestFunctions extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();

		$cat_id = $this->factory->category->create();
		$series_id = $this->factory->term->create(array(
			'taxonomy' => 'series'
		));
		global $considered;
		$considered = $this->factory->post->create(array(
			'post_category' => array($cat_id),
			'tax_input' => array(
				'series' => $series_id
			)
		));
	}

	function test___construct() {
		// check that Largo_Related->number equals 1 if number is not set
		$lr = new Largo_Related();
		/*
		 *
		 * State of this on Friday evening: I can't create a new Largo_Related in a way that actually triggers it as an object and not as an associative array. 
		 *
		 *
		$this->assertEquals(1, $lr->number);

		$lr = new Largo_Related(4);
		$this->assertEquals(4, $lr->number);
		// check that Largo_Related->post_id is the value of the set post, or the value of the global post
		global $post;
		$this->assertEquals($post->id, $lr->post_id);

		$lr = new Largo_Related(4, $considered);
		$this->assertEquals($considered, $lr->post_id);
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_popularity_sort() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	/**
	 * Test the function with a lot of different conditions
	 *
	 * - Series without organization
	 *		- one post published after the current post
	 *		- one post published before the current post
	 * - Series with CFTL post with organization information
	 *		- ASC
	 *		- series_custom
	 *		- DESC
	 *		- featured, DESC
	 *		- featured, ASC
	 * - No series, but category
	 *		- one post published after the current post
	 *		- one post published before the current post
	 * - No series, but tag
	 * - Tags and Categories
	 * - No series or category or tag
	 */

	function test_unorganized_series() {
		of_set_option('series_enabled', 1);
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_series_asc() {
		of_set_option('series_enabled', 1);
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_series_series_custom() {
		of_set_option('series_enabled', 1);
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_series_desc() {
		of_set_option('series_enabled', 1);
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_series_featured_desc() {
		of_set_option('series_enabled', 1);
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_series_featured_asc() {
		of_set_option('series_enabled', 1);
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_category() {
		of_set_option('series_enabled', false);
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_tags() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_category_and_tag() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_recent_posts() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
}

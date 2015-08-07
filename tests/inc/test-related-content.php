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
	}

	function test___construct() {
		// check that Largo_Related->number equals 1 if number is not set
		// check that Largo_Related->post_id is the value of the set post, or the value of the global post
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
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_series_asc() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_series_series_custom() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_series_desc() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_series_featured_desc() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_series_featured_asc() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}

	function test_category() {
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

<?php
class TaxonomiesTestFunctions extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();

		// Test data
		$this->author_user_ids = $this->factory->user->create_many(10, array('role' => 'author'));;
		$this->contributor_user_ids = $this->factory->user->create_many(5, array('role' => 'contributor'));
	}
	
	function test_largo_is_series_enabled() {
		// Series option has not been touched yet (a new install)
		$result = largo_is_series_enabled();
		$this->assertFalse($result);

		// Series option is to not enable series
		of_set_option('series_enabled', false);
		$result = largo_is_series_enabled();
		$this->assertFalse($result);

		// Series option is to enable series
		of_set_option('series_enabled', 1);
		$result = largo_is_series_enabled();
		$this->assertTrue($result);
	}
	function test_largo_custom_taxonomies(){
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_post_in_series() {
		// If series are disabled:
		of_set_option('series_enabled', false);
		$result = largo_post_in_series();
		$this->assertFalse($result);

		// If series are enabled:
		of_set_option('series_enabled', 1);
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_custom_taxonomy_terms() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_term_to_label() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_get_series_posts() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_largo_categoy_archive_posts() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_hide_post_type_taxonomy_menu() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_hide_post_type_taxonomy_metabox() {
		$this->markTestIncomplete('This test has not been implemented yet.');
	}
	function test_hide_post_type_taxonomy_table() {
		$this->markTestSkipped('This function has not been written yet.');
	}
}


<?php

class PostTagsTestFunctions extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();

	}

	function test_largo_time() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_author() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_author_link() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_byline() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_post_social_links() {
		// Create a post, go to it.
		$id = $this->factory->post->create();
		$this->go_to('/?p=' . $id);

		// Test the output of this when no options are set
		$this->assertFalse(of_get_option('article_utilities'));

		ob_start();
		largo_post_social_links();
		$ret = ob_get_clean();
		$this->assertRegExp('/post-social/', $ret, "The .post-social class was not in the output");
		$this->assertRegExp('/left/', $ret, "The .left class was not in the output");
		$this->assertRegExp('/right/', $ret, "The .right class was not in the output");
		unset($ret);

		// Test that this outputs the expected data for each of the button types

		// Twitter
		of_set_option('article_utilities', array('twitter' => '1', 'facebook' => false, 'print' => false, 'email' => false));
		of_set_option('twitter_link', 'foo');
		of_set_option('show_twitter_count', false);
		ob_start();
		largo_post_social_links();
		$ret = ob_get_clean();
		$this->assertRegExp('/' . preg_quote(of_get_option('twitter_link'), '/') . '/' , $ret, "The Twitter link did not appear in the output");
		// @TODO: insert a test for the get_the_author_meta test here
		// This is just a test for make sure that it outputs the data-count when show_twitter_count == 0,; needs another go-round for '1'
		$this->assertRegExp('/' . __('Tweet', 'largo') . '/', $ret, "The translation of 'Tweet' was not in the Twitter output");
		unset($ret);
		of_reset_options();

		// Facebook
		of_set_option('article_utilities', array('facebook' => '1', 'twitter' => false, 'print' => false, 'email' => false));
		ob_start();
		largo_post_social_links();
		$ret = ob_get_clean();
		$this->assertRegExp('/' . preg_quote(esc_attr( of_get_option( 'fb_verb' ) ), '/' ) . '/', $ret, "The Facebook Verb was not in the Facebook output");
		$this->assertRegExp('/' . preg_quote(get_permalink(), '/') . '/', $ret, "The permalink was not in the Facebook output");
		unset($ret);
		of_reset_options();

		// Print
		of_set_option('article_utilities', array('print' => '1', 'twitter' => '1', 'facebook' => false, 'email' => false));
		ob_start();
		largo_post_social_links();
		$ret = ob_get_clean();
		$this->assertRegExp('/print/', $ret, "The Print output did not include a print class");
		unset($ret);
		of_reset_options();

		// Email
		of_set_option('article_utilities', array('email' => '1', 'twitter' => false, 'facebook' => false, 'print' => false));
		ob_start();
		largo_post_social_links();
		$ret = ob_get_clean();
		$this->assertRegExp('/email/', $ret, "The Email output did not include an email class");
		unset($ret);
		of_reset_options();

	}

	function test_largo_has_avatar() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_my_queryvars() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_custom_wp_link_pages() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_excerpt() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_trim_sentences() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_content_nav() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_comment() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_post_type_icon() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_hero_class() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_hero_with_caption() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

	function test_largo_post_metadata() {
		$this->markTestIncomplete("This test has not yet been implemented.");
	}

}

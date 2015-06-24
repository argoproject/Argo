<?php

class PostTagsTestFunctions extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();

		$this->post_excerpt = <<<EOT
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque cursus purus id pharetra dapibus.
EOT;

		$this->post_id = $this->factory->post->create(array(
			'post_excerpt' => $this->post_excerpt,
		));
	}

	function test_largo_time() {
		$id = $this->factory->post->create();

		// Test with $echo = false
		$result = largo_time(false, $id);
		$this->assertTrue(!empty($result));

		// Test with $echo = true
		$this->expectOutputRegex('/<span class\="time\-ago">.*ago<\/span>/');
		largo_time(true, $id);

		// Make sure `largo_time` can determine the post id properly
		global $post;
		$save = $post;
		$post = get_post($id);
		setup_postdata($post);

		$another_result = largo_time(false);
		$this->assertEquals($result, $another_result);

		wp_reset_postdata();
		$post = $save;
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
		of_set_option('article_utilities', array(
			'facebook' => false,
			'twitter' => false,
			'print' => false,
			'email' => false
		));

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

	/**
	 * @expectedDeprecated largo_excerpt
	 */
	function test_largo_excerpt() {
		$this->expectDeprecated();

		$id = $this->factory->post->create(array(
			'post_content' => '<span class="first-letter"><b>S</span>entence</b> <i>one<i>. Sentence two. Sentence three. Sentence four. Sentence five. Sentence six. Sentence seven. Sentence eight. Sentence nine. Sentence ten. <!--more--> This should never display.',
			// Start with nothing because we want to make sure
			// largo_excerpt generates something acceptable
			'post_excerpt' => false
		));

		/**
		 * Test that the echo variable is respected
		 */
		ob_start();
		$ret = largo_excerpt($id, 5,true, '', true);
		$echo = ob_get_clean();
		$this->assertTrue(!empty($ret)); // The $output is always returned
		$this->assertTrue(!empty($echo)); // We want to make sure that it all works

		ob_start();
		$ret = largo_excerpt($id, 5, true, '', false);
		$echo = ob_get_clean();
		$this->assertTrue(!empty($ret));
		$this->assertTrue(empty($echo)); // With echo to false, this should not have anything in it

		/**
		 *  Test the sentence count output.
		 */
		$ret = largo_excerpt($id, 1, null, null, false);
		$this->assertEquals(
			"<p>Sentence one. </p>\n", $ret,
			"Only one sentence should be output when the count of sentences is 1.");

		$ret = largo_excerpt($id, 5, null, null, false);
		$this->assertEquals(
			"<p>Sentence one. Sentence two. Sentence three. Sentence four. Sentence five. </p>\n", $ret,
			"Only five sentences should be output when the count of sentences is 5.");

		$ret = largo_excerpt($id, 11, null, null, false);
		$this->assertEquals(
			"<p>Sentence one. Sentence two. Sentence three. Sentence four. Sentence five. Sentence six. Sentence seven. Sentence eight. Sentence nine. Sentence ten. This should never display. </p>\n", $ret,
			"11 sentences should be output when the count of sentences is 11.");

		/**
		 * Test that if we're on the homepage and the post has a more tag, that gets used if there is no post excerpt
		 */
		$this->go_to('/'); // Go home
		$ret = largo_excerpt($id, 1, null, null, false);
		$this->assertEquals(
			"<p>Sentence one. Sentence two. Sentence three. Sentence four. Sentence five. Sentence six. Sentence seven. Sentence eight. Sentence nine. Sentence ten. </p>\n", $ret,
			"Always obey the <!-- more --> tag for excerpts on the home page.");

		// And now with an excerpt
		wp_update_post(
			array(
				'ID' => $id,
				'post_content' => '<span class="first-letter"><b>S</span>entence</b> <i>one<i>. Sentence two. Sentence three. Sentence four. Sentence five. Sentence six. Sentence seven. Sentence eight. Sentence nine. Sentence ten. <!--more--> This should never display.',
				'post_excerpt' => 'Custom post excerpt!'
			)
		);

		$this->go_to('/'); // Go home
		$ret = largo_excerpt($id, 1, null, null, false);
		$this->assertEquals(
			"<p>Custom post excerpt!</p>\n", $ret,
			"Custom post excerpt did not output.");
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

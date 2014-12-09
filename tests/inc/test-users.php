<?php

// Test functions in inc/users.php
class UsersTestFunctions extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();

		// Test data
		$this->author_user_ids = $this->factory->user->create_many(10, array('role' => 'author'));;
		$this->contributor_user_ids = $this->factory->user->create_many(5, array('role' => 'contributor'));
	}

	function test_largo_contactmethods() {
		$this->markTestSkipped("Not implemented");
	}

	function test_largo_filter_guest_author_fields() {
		$this->markTestSkipped("Not implemented");
	}

	function test_largo_admin_users_caps() {
		$this->markTestSkipped("Not implemented");
	}

	function test_largo_edit_permission_check() {
		$this->markTestSkipped("Not implemented");
	}

	function test_clean_user_twitter_username() {
		$this->markTestSkipped("Not implemented");
	}

	function test_validate_twitter_username() {
		$this->markTestSkipped("Not implemented");
	}
	
	function test_clean_user_fb_username() {
		$this->markTestSkipped("Not implemented");
	}
	
	function test_validate_fb_username() {
		$this->markTestSkipped("Not implemented");
	}

	function test_largo_get_user_list() {
		/**
		 * With no arguments, `largo_get_user_list` should get a list of all authors for the current blog;
		 */
		$result = largo_get_user_list();
		$ids = array_map(function($user) { return $user->ID; }, $result);

		$this->assertEquals(count($ids), count($this->author_user_ids));

		// Make sure all of the ids in the list returned by `largo_get_user_list` are the same as
		// those in $this->author_user_ids
		$not_present = array();
		foreach ($ids as $id) {
			if (!in_array($id, $this->author_user_ids))
				$not_present[] = $id;
		}
		$this->assertEmpty($not_present);

		unset($result);
		unset($ids);

		/**
		 * When we specify a role, we should get back only users with that role.
		 */
		$result = largo_get_user_list(array('roles' => array('contributor')));
		$ids = array_map(function($user) { return $user->ID; }, $result);

		$this->assertEquals(count($ids), count($this->contributor_user_ids));

		// Make sure all of the ids in the list returned by `largo_get_user_list` are the same as
		// those in $this->contribut_user_ids
		$not_present = array();
		foreach ($ids as $id) {
			if (!in_array($id, $this->contributor_user_ids))
				$not_present[] = $id;
		}
		$this->assertEmpty($not_present);

		unset($result);
		unset($ids);

		/**
		 * When we specify multiple roles, we should get back a list of users with any of the roles specified.
		 */
		$result = largo_get_user_list(array('roles' => array('contributor', 'author')));
		$ids = array_map(function($user) { return $user->ID; }, $result);

		$this->assertEquals(count($ids), count($this->contributor_user_ids) + count($this->author_user_ids));

		// Make sure all of the ids in the list returned by `largo_get_user_list` are the same as
		// those in $this->contributor_user_ids and $this->author_user_ids
		$not_present = array();
		foreach ($ids as $id) {
			if (!in_array($id, $this->contributor_user_ids) && !in_array($id, $this->author_user_ids))
				$not_present[] = $id;
		}
		$this->assertEmpty($not_present);

		unset($result);
		unset($ids);
	}

	function test_largo_render_user_list() {
		$this->markTestSkipped("Not implemented");
	}

	function test_largo_render_staff_list_shortcode() {
		$this->markTestSkipped("Not implemented");
	}
}

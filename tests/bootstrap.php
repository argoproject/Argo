<?php

$wp_tests_dir = getenv('WP_TESTS_DIR');
require_once $wp_tests_dir . '/includes/functions.php';

$GLOBALS['wp_tests_options'] = array(
	'stylesheet' => 'largo-dev',
	'template' => 'largo-dev'
);

tests_add_filter('set_current_user', function($arg) {
	$user = wp_get_current_user();
	$user->set_role('administrator');
	return $arg;
}, 1, 10);

tests_add_filter('filesystem_method', function($arg) {
	return 'Direct';
}, 1, 10);

require dirname(__FILE__) . '/inc/mock-options-framework.php';
require $wp_tests_dir . '/includes/bootstrap.php';

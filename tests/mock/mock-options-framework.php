<?php
/**
 * The options framework doesn't load in context of tests,
 * so we need a way to mock its API when testing Largo
 **/

class MockOptionsFramework {

	var $options = array();

	function __construct() {
		tests_add_filter('wp_loaded', array($this, 'populate_defaults'));
	}

	public function populate_defaults() {
		include_once(ABSPATH . 'wp-admin/includes/screen.php');
		include_once(dirname(dirname(__DIR__)) . '/options.php');
		// Suppress notices resulting from call to of_get_default_values.
		// We're not testing the options framework here.
		$this->options = array_merge($this->options, @of_get_default_values());
	}

	public function get_option($name, $default=false) {
		if (isset($this->options[$name]))
			return $this->options[$name];
		else
			return $default;
	}

	public function set_option($name, $value=null) {
		if (isset($this->options[$name]) && $this->options[$name] == $value)
			return false;
		else {
			$this->options[$name] = $value;
			return true;
		}
	}

	public function reset_options() {
		$this->options = array();
		$this->populate_defaults();
	}
}

$GLOBALS['mock_options_framework'] = new MockOptionsFramework();

function of_set_option($name, $value) {
	return $GLOBALS['mock_options_framework']->set_option($name, $value);
}

function of_get_option($name, $default=false) {
	return $GLOBALS['mock_options_framework']->get_option($name, $default);
}

function of_reset_options() {
	return $GLOBALS['mock_options_framework']->reset_options();
}

<?php

if (empty($wp_filesystem)) {
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	WP_Filesystem();
}

class Homepage {

	var $name = 'Homepage';
	var $id;
	var $type = 'homepage';
	var $description;
	var $template;
	var $assets;
	var $zones;

	function __construct($options=array()) {
		$this->load($options);
	}

	public function load($options) {
		$vars = get_object_vars($this);
		foreach ($options as $k => $v) {
			if (in_array($k, array_keys($vars)))
				$this->{$k} = $v;
		}
		if (empty($this->id))
			$this->populateId();
		else if (sanitize_title($this->id) !== $this->id)
			throw new Exception('Homepage `id` can only contain letters, numbers and hyphens.');

		$this->readZones();
	}

	private function populateId() {
		$this->id = sanitize_title($this->name);
	}

	private function readZones() {
		global $wp_filesystem;

		$contents = $wp_filesystem->get_contents($this->template);
		$tokens = token_get_all($contents);
		$filtered = array_filter($tokens, function($t) { return $t[0] == T_VARIABLE; });
		$variables = array_map(function($item) { return str_replace("$", "", $item[1]); }, $filtered);
		$uniques = array_values(array_unique($variables));

		$this->zones = $uniques;
	}

	public function render() {
		$vars = array(
			'templateId' => $this->id,
			'templateType' => $this->type
		);
		foreach ($this->zones as $zone) {
			if (!empty($this->{$zone})) {
				if (function_exists($this->{$zone})) {
					$vars[$zone] = call_user_func($this->{$zone});
				} else if (is_string($this->{$zone})) {
					$vars[$zone] = $this->{$zone};
				}
			} else {
				if (method_exists($this, $zone))
					$vars[$zone] = call_user_func(array($this, $zone));
			}
		}
		extract($vars);
		include_once $this->template;
	}

	public function register() {
		add_action('wp_enqueue_scripts', array($this, 'enqueueAssets'), 100);
	}

	public function enqueueAssets() {
		foreach ($this->assets as $asset) {
			if (preg_match('/\.js$/', $asset[1]))
				call_user_func_array('wp_enqueue_script', $asset);
			if (preg_match('/\.css$/', $asset[1]))
				call_user_func_array('wp_enqueue_style', $asset);
		}
	}
}

class HomepageLayoutFactory {
	var $layouts = array();

	function __construct() {
		add_action('widgets_init', array($this, 'register_layouts'), 100);
	}

	function register($layoutClass) {
		$this->layouts[$layoutClass] = new $layoutClass();
	}

	function unregister($layoutClass) {
		if (isset($this->layouts[$layoutClass]))
			unset($this->layouts[$layoutClass]);
	}

	function register_layouts() {
		foreach ($this->layouts as $layout)
			$layout->register();
	}
}

function register_homepage_layout($layoutClass) {
	global $largo_homepage_factory;

	$largo_homepage_factory->register($layoutClass);
}

function unregister_homepage_layout($layoutClass) {
	global $largo_homepage_factory;

	$largo_homepage_factory->unregister($layoutClass);
}

$GLOBALS['largo_homepage_factory'] = new HomepageLayoutFactory();



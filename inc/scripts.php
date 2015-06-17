<?php

class LargoScripts {
	private $scripts;

	public function __construct($scripts=null) {
		if (isset($_GET['debug']) && $_GET['debug'])
			$this->debug = true;

		$this->scripts = (empty($scripts))? array() : $scripts;
	}

	public function add($name, $path) {
		$this->scripts[$name] = $path;
	}

	public function addMany($scripts) {
		foreach ($scripts as $name => $path)
			$this->add($name, $path);
	}

	public function remove($name) {
		unset($this->scripts[$name]);
	}

	public function render() {
		$this->headers();

		ob_start();
		foreach ($this->scripts as $name => $path) {
			if (file_exists($path))
				include_once $path;
			else
				continue;
		}
		$contents = ob_get_contents();
		ob_end_clean();

		print $contents;
		exit;
	}

	public function headers() {
		$expires_offset = 31536000; // 1 year
		header('Content-Type: application/javascript');
		header('Expires: ' . gmdate( "D, d M Y H:i:s", time() + $expires_offset ) . ' GMT');
		header("Cache-Control: public, max-age=$expires_offset");
	}
}

$core_scripts = array(
	'largo-core' => dirname(__DIR__) . '/js/core/largo-core.js',
	'largo-sticky-elements' => dirname(__DIR__) . '/js/core/largo-sticky-elements.js',
	'largo-custom-share-buttons' => dirname(__DIR__) . '/js/core/largo-custom-share-buttons.js',
	'largo-mobile-search' => dirname(__DIR__) . '/js/core/largo-mobile-search.js',
	'largo-responsive-nav' => dirname(__DIR__) . '/js/core/largo-responsive-nav.js'
);

$largo_scripts = new LargoScripts($core_scripts);
$largo_scripts->render();

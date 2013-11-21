<?php
/**
 * Functions to scour for homepage templates and build an array of them.
 * The array is then fed into options_framework settings for homepage layout
 * And that setting is fetched to display the proper homepage
 */

//	This function scans the template files of the active theme,
//	and returns an array of [Template Name => {file}.php]
if( !function_exists( 'get_homepage_templates' ) ) {

	function largo_get_homepage_templates() {

		$theme = wp_get_theme();
		$php_files = $theme->get_files( 'php', 1, true );
		$home_templates = array();

		$base = array(trailingslashit(get_template_directory()), trailingslashit(get_stylesheet_directory()));

		foreach ( (array)$php_files as $template ) {
			$template = WP_CONTENT_DIR . str_replace(WP_CONTENT_DIR, '', $template);
			$basename = str_replace($base, '', $template);

			$template_data = implode('', file( $template ));

			$name = '';
			if ( basename($template) != basename(__FILE__) && preg_match( '|Home Template:(.*)$|mi', $template_data, $name) ) {
				$name = _cleanup_header_comment($name[1]);
				$home_templates[ trim($name) ] = array(
					'path' => $basename,	//eg 'homepages/my-homepage.php'
					'img' => largo_get_homepage_thumb( $theme, $basename ),
				);
			}
		}

		return $home_templates;

	}
}


function largo_get_homepage_thumb( $theme, $file ) {
	$pngs = $theme->get_files( 'png', 1, true );
	$our_filename = basename( $file, '.php' ) . '.png';
	foreach ( (array)$pngs as $filename => $server_path ) {
		if ( basename($filename) == $our_filename ) {
			return str_replace( WP_CONTENT_DIR, get_theme_root_uri(), $server_path);
		}
	}
}
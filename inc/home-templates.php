<?php
/**
 * Functions to scour for homepage templates and build an array of them.
 * The array is then fed into options_framework settings for homepage layout
 * And that setting is fetched to display the proper homepage
 */

/**
 * Scans theme (and parent theme) for homepage templates.
 *
 * @return array An array of templates, with friendly names as keys and arrays with 'path' and 'thumb' as values
 */
if( !function_exists( 'get_homepage_templates' ) ) {

	function largo_get_home_templates() {

		$theme = wp_get_theme();
		$php_files = $theme->get_files( 'php', 1, true );
		$home_templates = array();

		$base = array(trailingslashit(get_template_directory()), trailingslashit(get_stylesheet_directory()));

		foreach ( (array)$php_files as $template ) {
			$template = WP_CONTENT_DIR . str_replace(WP_CONTENT_DIR, '', $template);
			$basename = str_replace($base, '', $template);

			$template_data = implode('', file( $template ));

			$name = $desc = '';
			if ( basename($template) != basename(__FILE__) && preg_match( '|Home Template:(.*)$|mi', $template_data, $name) ) {
				$name = _cleanup_header_comment($name[1]);
				preg_match( '|Description:(.*)$|mi', $template_data, $desc);
				$home_templates[ trim($name) ] = array(
					'path' => $basename,	//eg 'homepages/my-homepage.php'
					'thumb' => largo_get_home_thumb( $theme, $basename ),
					'desc' => _cleanup_header_comment($desc[1])
				);
			}
		}

		return $home_templates;

	}
}

/**
 * @return string The public url of the image file to use for the given template's screenshot
 */
function largo_get_home_thumb( $theme, $file ) {
	$pngs = $theme->get_files( 'png', 1, true );
	$our_filename = basename( $file, '.php' ) . '.png';
	foreach ( (array)$pngs as $filename => $server_path ) {
		if ( basename($filename) == $our_filename ) {
			return str_replace( WP_CONTENT_DIR, content_url(), $server_path);
		}
	}

	//still here? Use a default
	return get_template_directory_uri() . '/homepages/no-thumb.png';
}

function largo_home_template_path() {
	$tpl = of_get_option( 'home_template' );
	if ( ! $tpl ) return false;
	if ( file_exists( get_stylesheet_directory() . "/$tpl") ) {
		return get_stylesheet_directory() . "/$tpl";
	} else if ( file_exists( get_template_directory() . "/$tpl") ) {
		return get_template_directory() . "/$tpl";
	}
	return false;
}

function largo_home_template_sidebars() {
	$path = largo_home_template_path();
	$sidebar_string = '';
	$template_data = implode('', file( $path ));
	preg_match( '|Sidebars:(.*)$|mi', $template_data, $sidebar_string );
	$sidebars = explode(",", $sidebar_string[1]);
	return array_map( 'trim', $sidebars );
}
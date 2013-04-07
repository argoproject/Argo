<?php
/**
 * Functionality for converting the variable.less into 
 * theme options page that will recompile into new CSS.
 */


/*
Need to know

- variable.less for theme options
- save user defined values into options
- Less files to compiled into CSS
- Rewrite the URLs into dynamic URLs

*/

/**
 * Setup
 */
add_action( 'largo_init_custom_less_variables', 'largo_init_custom_less_variables' );
function largo_init_custom_less_variables() {
	largo_register_less_files( array( 'bootstrapify.less', 'carousel.less', 'editor-style.less', 'style.less', 'top-stories.less' ) );
}


/**
 * Register which Less files are to be compiled into CSS
 * for the user customized values to override variables.less.
 *
 * @param array $files - list of filenames in the less directory
 */
function largo_register_less_files( $files ) {
	Largo_Custom_Less_Variables::register_files( $files );
}


class Largo_Custom_Less_Variables {

	// Variables
	static $less_files = array();
	static $css_files = array();



	/**
	 * Kickoff it off
	 */
	static function init() {
		do_action( 'largo_init_custom_less_variables' );

		add_filter( 'style_loader_src', array( 'Largo_Custom_Less_Variables', 'style_loader_src' ), 10, 2 );
		add_action( 'template_redirect', array( 'Largo_Custom_Less_Variables', 'template_redirect') );
	}


	/**
	 * Register the Less files to compile into CSS files
	 */
	static function register_files( $files ) {
		self::$less_files = (array) $files;

		$css_files = array();
		foreach ($files as $key => $file ) {
			$css_files[$key] = preg_replace( '#\.less$#', '.css', $file );
		}
		self::$css_files = $css_files;
	}


	static function compile_less( $less_file ) {


		if ( !class_exists('lessc') ) {
			require( dirname( __FILE__ ) . '/lib/lessc.inc.php' );
		}

		$compiler = new lessc();
		$compiler->addImportDir( get_template_directory() . '/less/' );

		try {
			// Get the Less file and then replace variables.less with the update version
			$less = file_get_contents( get_template_directory() . '/less/' . $less_file );
			$less = self::replace_with_custom_variables( $less );

			return $compiler->compile( $less );
		} catch ( Exception $e ) {
			return $less;
		}

	}


	/**
	 * Replace the include for the variable file with a modified version
	 * with the custom values.
	 */
	static function replace_with_custom_variables( $less ) {
		$variables_less = file_get_contents(get_template_directory() . '/less/variables.less' );

		preg_match_all( '#^@(?P<name>[\w-_]+):\s*(?P<value>[^;]*);#m', $variables_less, $matches );

		$variables = array(
			'linkColor' => 'red',
		);

		foreach ( $matches[0] as $index => $rule ) {
			$name = $matches['name'][$index];

			if ( !empty( $variables[$name] ) ) {
				$replacement_rule = "@{$name}: {$variables[$name]};";
				$variables_less = str_replace( $rule, $replacement_rule, $variables_less);
			}
		}

		$less = preg_replace( '#^@import ["\']variables(\.less)?["\'];#m', $variables_less, $less );

		return $less;
	}


	static function style_loader_src( $src, $handle ) {
		$base_url = get_template_directory_uri() . '/css/';
		$base_url_escape = preg_quote( $base_url );

		foreach ( self::$css_files as $key => $filename ) {
			if ( preg_match( '!^'.$base_url_escape. preg_quote( $filename ) .'(?<extra>[#\?].*)?$!', $src, $matches ) ) {
				return add_query_arg( 
					array( 'largo_custom_less_variable' => 1, 'css_file' => $filename ),
					home_url( $matches['extra'] )
				);
			}
		}
		return $src;
	}


	/**
	 * Intercept custom CSS
	 */
	static function template_redirect() {
		// Abort if not our call
		if ( !filter_input( INPUT_GET, 'largo_custom_less_variable', FILTER_VALIDATE_BOOLEAN ) ) {
			return;
		}

		$css_file = filter_input( INPUT_GET, 'css_file', FILTER_SANITIZE_STRING );

		header( 'Content-Type: text/css', true, 200 );

		// Echo nothing if the file is missing
		if ( empty( $css_file ) ) {
			echo '';
			exit;
		}

		$key = array_search( $css_file, self::$css_files );

		// Echo nothing if file is not registered
		if ( $key===false ) {
			echo '';
			exit;
		}

		echo self::compile_less( self::$less_files[$key] );

		exit;
	}
}

Largo_Custom_Less_Variables::init();




// lessc->addImportDir


//add_action( 'template_redirect', 'largo_less_test');
function largo_less_test() {
	
	//echo largo_compile_less( $less, array( 'bg-color' => 'yellow' ) );
	$less = file_get_contents( get_template_directory() . '/less/style.less' );

	echo '<pre>';

	echo Largo_Custom_Less_Variables::replace_with_custom_variables( $less );

	echo '</pre>';

	//echo largo_compile_less( 'style.less' );

	exit;
}





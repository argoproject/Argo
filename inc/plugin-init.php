<?php
/**
 * @package    TGM-Plugin-Activation
 * @version    2.5.2 for parent theme Largo for publication on WordPress.org
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 * @see 		http://tgmpluginactivation.com/configuration/ for detailed documentation.
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../lib/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'largo_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function largo_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Our plugins from the WordPress Plugin Repository
		array(
			'name' 		=> 'Link Roundups',
			'slug' 		=> 'link-roundups',
			'required' 	=> false,
		),
		
		array(
			'name' 		=> 'Super Cool Ad Inserter',
			'slug' 		=> 'super-cool-ad-inserter',
			'required' 	=> false,
		),
		
		array(
			'name' 		=> 'DoubleClick for WordPress',
			'slug' 		=> 'doubleclick-for-wp',
			'required' 	=> false,
		),
		
		// Other commonly used plugins from the WordPress plugin repository
		array(
			'name' 		=> 'DocumentCloud',
			'slug' 		=> 'documentcloud',
			'required' 	=> false,
		),

		array(
			'name' 		=> 'Co-Authors Plus',
			'slug' 		=> 'co-authors-plus',
			'required' 	=> false,
		),
		
		array(
			'name' 		=> 'Disqus Comment System',
			'slug' 		=> 'disqus-comment-system',
			'required' 	=> false,
		),

		array(
			'name' 		=> 'Better WordPress Google XML Sitemaps',
			'slug' 		=> 'bwp-google-xml-sitemaps',
			'required' 	=> false,
		),
		
		// Our plugins from GitHub
		array(
			'name' 		=> 'Analytic Bridge',
			'slug' 		=> 'analytic-bridge',
			'source' 	=> 'https://github.com/INN/analytic-bridge/archive/master.zip',
			'required'	=> false,
		),
		array(
			'name' 		=> 'News Quiz',
			'slug' 		=> 'news-quiz',
			'source' 	=> 'https://github.com/INN/news-quiz/archive/master.zip',
			'required'	=> false,
		),
		array(
			'name' 		=> 'Tweetable Text',
			'slug' 		=> 'tweetable-text',
			'source' 	=> 'https://github.com/INN/tweetable-text/archive/master.zip',
			'required'	=> false,
		),

	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'largo';

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'largo',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'largo' ),
			'menu_title'                      => __( 'Install Plugins', 'largo' ),
			'installing'                      => __( 'Installing Plugin: %s', 'largo' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'largo' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'largo'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'largo'
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'largo'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'largo'
			), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'largo'
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'largo'
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'largo'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'largo'
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'largo'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'largo'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'largo'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'largo'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'largo' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'largo' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'largo' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'largo' ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'largo' ),  // %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'largo' ), // %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'largo' ),

			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
		*/ 
	);

	tgmpa( $plugins, $config );

	// Hide notices from users that can't do anything about them.
	// A future update to TGMPA intends to fix this issue on multisites.
	// @see: https://github.com/TGMPA/TGM-Plugin-Activation/pull/247
	//
	// This should be removed after TGMPA is updated to version 3.0
	if( !current_user_can('activate_plugins') )
		TGM_Plugin_Activation::$instance->has_notices = false;

}

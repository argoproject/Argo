<?php
/**
 * Adds site verification meta tags for various services
 * Descriptions of what these are used for can be found in options.php
 * or in the Appearance > Theme Options > Advanced section of the WP admin
 *
 * @since 0.3
 */
function largo_verify() {

	// These services only require the verification meta tag on the homepage
	if ( is_home() ) {
		if ( of_get_option( 'twitter_acct_id') ) {
			echo '<meta property="twitter:account_id" content="' . of_get_option( 'twitter_acct_id') . '" />';
		}
		if ( of_get_option( 'google_site_verificatio') ) {
			echo '<meta name="google-site-verification" content="' . of_get_option( 'google_site_verification') . '" />';
		}
		if ( of_get_option( 'bitly_verification') ) {
			echo '<meta name="bitly-verification" content="' . of_get_option( 'bitly_verification') . '"/>';
		}
	}

	// Facebook uses these for any page that creates an associated open graph object so we need them on every page
	if ( of_get_option( 'fb_admins') ) {
		echo '<meta property="fb:admins" content="' . of_get_option( 'google_site_verification') . '" />';
	}
	if ( of_get_option( 'fb_app_id') ) {
		echo '<meta property="fb:app_id" content="' . of_get_option( 'google_site_verification') . '" />';
	}
}
add_action( 'wp_head', 'largo_verify' );
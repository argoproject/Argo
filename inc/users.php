<?php

/**
 * Modify the user profile screen
 * Remove old links and add some new ones
 *
 * @since 1.0
 */
function largo_contactmethods( $contactmethods ) {
	// Remove Yahoo IM
	if ( isset( $contactmethods['yim'] ) )
		unset( $contactmethods['yim'] );

	// Remove AIM
	if ( isset( $contactmethods['aim'] ) )
	    unset( $contactmethods['aim'] );

	// Remove Jabber
	if ( isset( $contactmethods['jabber'] ) )
	    unset( $contactmethods['jabber'] );

	// Add a format hint for G+
	$contactmethods['googleplus'] = 'Google+<br><em>https://plus.google.com/userID/<em>';

	// Add Twitter
	if ( !isset( $contactmethods['twitter'] ) )
	    $contactmethods['twitter'] = 'Twitter<br><em>https://twitter.com/username<em>';

	// Add Facebook
	if ( !isset( $contactmethods['fb'] ) )
		$contactmethods['fb'] = 'Facebook<br><em>https://www.facebook.com/username<em>';

	// Add LinkedIn
	if ( !isset( $contactmethods['linkedin'] ) )
		$contactmethods['linkedin'] = 'LinkedIn<br><em>http://www.linkedin.com/in/username<em>';

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'largo_contactmethods', 10, 1 );
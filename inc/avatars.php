<?php

// Include avatars module
include_once dirname(__FILE__) . '/avatars/functions.php';

/**
 * Determine whether or not an author has a valid gravatar image
 * see: http://codex.wordpress.org/Using_Gravatars
 *
 * @param $email string an author's email address
 * @return bool true if a gravatar is available for this user
 * @since 0.3
 */
function largo_has_gravatar( $email ) {
	// Craft a potential url and test its headers
	$hash = md5( strtolower( trim( $email ) ) );

	$cache_key = 'largo_has_gravatar_' . $hash;
	if ( false !== ( $cache_value = get_transient( $cache_key ) ) ) {
		return (bool) $cache_value;
	}

	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$response = wp_remote_head( $uri );
	if ( 200 == wp_remote_retrieve_response_code( $response ) ) {
		$cache_value = '1';
	} else {
		$cache_value = '0';
	}
	set_transient( $cache_key, $cache_value );
	return (bool) $cache_value;
}

/**
 * Determine whether or not a user has an avatar. Fallback checks if user has a gravatar.
 *
 * @param $email string an author's email address
 * @return bool true if an avatar is available for this user
 * @since 0.4
 */
function largo_has_avatar( $email ) {
	$user = get_user_by( 'email', $email );
	$result = largo_get_user_avatar_id( $user->ID );
	if ( ! empty ( $result ) ) {
		return true;
	} else {
		if ( largo_has_gravatar( $email ) ) {
			return true;
		}	
	}
	return false;
}

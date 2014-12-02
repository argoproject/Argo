<?php

/**
 * Modify the user profile screen
 * Remove old contact methods (yahoo, aol and jabber)
 * Add new ones (twitter, facebook, linkedin)
 *
 * @since 1.0
 */
function largo_contactmethods( $contactmethods ) {

	$remove = array( 'yim', 'aim', 'jabber' );
	foreach ( $remove as $service ) {
		if ( isset( $contactmethods[$service] ) )
			unset( $contactmethods[$service] );
	}

	$add = array(
		'twitter' 	=> 'Twitter<br><em>https://twitter.com/username<em>',
		'fb' 		=> 'Facebook<br><em>https://www.facebook.com/username<em>',
		'linkedin' 	=> 'LinkedIn<br><em>http://www.linkedin.com/in/username<em>'
	);
	foreach ( $add as $service => $format ) {
		if ( !isset( $contactmethods[$service] ) )
	    	$contactmethods[$service] = $format;
	}

	// Add a format hint for G+
	$contactmethods['googleplus'] = 'Google+<br><em>https://plus.google.com/userID/<em>';

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'largo_contactmethods' );


/**
 * Same deal, but for guest authors in the Co-Authors Plus plugin
 * @TODO: figure out if there's a way to remove fields as we do for regular users above
 *
 * @since 1.0
 */
function largo_filter_guest_author_fields( $fields_to_return, $groups ) {

	if ( in_array( 'all', $groups ) || in_array( 'contact-info', $groups ) ) {
		$fields_to_return[] = array(
			'key'      => 'twitter',
			'label'    => 'Twitter<br><em>https://twitter.com/username<em>',
			'group'    => 'contact-info',
		);
		$fields_to_return[] = array(
			'key'      => 'fb',
			'label'    => 'Facebook<br><em>https://www.facebook.com/username<em>',
			'group'    => 'contact-info',
		);
		$fields_to_return[] = array(
			'key'      => 'linkedin',
			'label'    => 'LinkedIn<br><em>http://www.linkedin.com/in/username<em>',
			'group'    => 'contact-info',
		);
		$fields_to_return[] = array(
			'key'      => 'googleplus',
			'label'    => 'Google+<br><em>https://plus.google.com/userID/<em>',
			'group'    => 'contact-info',
		);
	}
	if ( in_array( 'all', $groups ) || in_array( 'name', $groups ) ) {
		$fields_to_return[] = array(
			'key'      => 'organization',
			'label'    => 'Organization',
			'group'    => 'name',
		);
	}

	return $fields_to_return;
}
add_filter( 'coauthors_guest_author_fields', 'largo_filter_guest_author_fields', 10, 2 );


/**
 * In a multisite network, allow site admins to edit user profiles
 * props: http://thereforei.am/2011/03/15/how-to-allow-administrators-to-edit-users-in-a-wordpress-network/
 *
 * @since 1.0
 */
function largo_admin_users_caps( $caps, $cap, $user_id, $args ){

    foreach( $caps as $key => $capability ){

        if( $capability != 'do_not_allow' )
            continue;

        switch( $cap ) {
            case 'edit_user':
            case 'edit_users':
                $caps[$key] = 'edit_users';
                break;
            case 'delete_user':
            case 'delete_users':
                $caps[$key] = 'delete_users';
                break;
            case 'create_users':
                $caps[$key] = $cap;
                break;
        }
    }

    return $caps;
}
add_filter( 'map_meta_cap', 'largo_admin_users_caps', 1, 4 );
remove_all_filters( 'enable_edit_any_user_configuration' );
add_filter( 'enable_edit_any_user_configuration', '__return_true');

/**
 * Checks that both the editing user and the user being edited are
 * members of the blog and prevents the super admin being edited.
 */
function largo_edit_permission_check() {
    global $current_user, $profileuser;

    $screen = get_current_screen();

    get_currentuserinfo();

    if( ! is_super_admin( $current_user->ID ) && in_array( $screen->base, array( 'user-edit', 'user-edit-network' ) ) ) { // editing a user profile
        if ( is_super_admin( $profileuser->ID ) ) { // trying to edit a superadmin while less than a superadmin
            wp_die( __( 'You do not have permission to edit this user.', 'largo' ) );
        } elseif ( ! ( is_user_member_of_blog( $profileuser->ID, get_current_blog_id() ) && is_user_member_of_blog( $current_user->ID, get_current_blog_id() ) )) { // editing user and edited user aren't members of the same blog
            wp_die( __( 'You do not have permission to edit this user.', 'largo' ) );
        }
    }

}
add_filter( 'admin_head', 'largo_edit_permission_check', 1, 4 );


/**
 * Cleans a Twitter url or an @username to the bare username
 * @param user_id 
 * @uses largo_twitter_url_to_username
 */

add_action('edit_user_profile_update', 'clean_user_twitter_username');
add_action('personal_options_update', 'clean_user_twitter_username');

function clean_user_twitter_username($user_id) {
	if ( current_user_can('edit_user', $user_id) ) {
		$twitter = largo_twitter_url_to_username( $_POST['twitter'] );
		if ( preg_match( '/[^a-zA-Z0-9_]/', largo_twitter_url_to_username( $tw_suspect ) ) ) {
			// it's not a valid twitter username, because it's got an invalid character
			$twitter = "";
		}
		update_user_meta($user_id, 'twitter_link', $twitter);
		if ( get_user_meta($user_id, 'twitter_link', true) != $twitter ) {
			wp_die(__('An error occurred.'));
		}
	}
}

/**
 * Checks that the Twitter URL is valid and chops it down to just the username
 * @uses largo_twitter_url_to_username
 */

add_action( 'user_profile_update_errors', 'validate_twitter_username', 10, 3);

function validate_twitter_username( $errors, $update, $user ) {

	if ( isset( $_POST["twitter"] ) ) {
		$tw_suspect = trim( $_POST["twitter"] );
		if( ! empty( $tw_suspect ) ) {
			if ( preg_match( '/[^a-zA-Z0-9_]/', largo_twitter_url_to_username( $tw_suspect ) ) ) {
				// it's not a valid twitter username, because it's got an invalid character
				$errors->add('twitter_username', __('The Twitter username entered, <b>' . $tw_suspect . '</b>, is invalid. Twitter usernames only use the uppercase and lowercase alphabet letters (a-z A-Z), the Arabic numbers (0-9), and underscores (_). '));
			}
		}
	}
}

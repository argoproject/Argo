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
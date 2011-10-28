<?php

add_action( 'show_user_profile', 'argo_staff_fields' );
add_action( 'edit_user_profile', 'argo_staff_fields' );

function argo_staff_fields( $user ) { ?>

<h3>Argo User Settings</h3>
	<table class="form-table">
	
		<tr>
			<th><label for="argo_twitter">Twitter username</label></th>
			<td>
				<input type="text" name="argo_twitter" id="argo_twitter" value="<?php echo esc_attr( get_the_author_meta( 'argo_twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Twitter username</span>
			</td>
		</tr>
		
		<tr>
		    <th>Blog Host?</th>
		    <td>
		        <input type="checkbox" name="argo_is_staff" id="argo_is_staff" value="1" <?php checked( 1, get_the_author_meta( 'argo_is_staff', $user->ID ) ); ?> /> <label for="argo_is_staff">Yes</label><br />
		        <span class="description">Blog hosts appear in the blog host widget.</span>
		    </td>
		</tr>
	</table>
    <?php
}

add_action( 'personal_options_update', 'argo_update_staff_fields' );
add_action( 'edit_user_profile_update', 'argo_update_staff_fields' );

function argo_update_staff_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_usermeta( $user_id, 'argo_twitter', $_POST['argo_twitter'] );
	update_usermeta( $user_id, 'argo_is_staff', $_POST['argo_is_staff']);
}

function argo_get_staff() {
    return get_users(
            array(
                'meta_key' => 'argo_is_staff',
                'meta_value' => 1
            )
        );
}

?>
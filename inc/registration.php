<?php

/**
 * Setup the new user signup process
 *
 * @since 0.4
 *
 * @uses apply_filters() filter $filtered_results
 * @uses largo_show_user_form() to display the user registration form
 * @param array $values the values for the sign up form inputs
 * @param array $errors
 */
function largo_signup_user($values=array(), $errors = '' ) {
	if ( !is_wp_error($errors) )
		$errors = new WP_Error();

	$form_values = array_merge(array(
		'user_login'  => '',
		'user_email' => '',
		'errors'     => $errors,
	), $values);

	/**
	 * Filter the default user variables used on the user sign-up form.
	 *
	 * @since 0.4
	 *
	 * @param array $signup_user_defaults {
	 *     An array of default user variables.
	 *
	 *     @type string $user_login  The user username.
	 *     @type string $user_email The user email address.
	 *     @type array  $errors     An array of possible errors relevant to the sign-up user.
	 * }
	 */
	$form_values = apply_filters('largo_signup_user_init', $form_values);
	$errors = $form_values['errors'];
	?>
	<form id="setupform" method="post">
		<?php
		do_action( 'signup_hidden_fields', 'validate-user' );
		?>
		<?php largo_show_user_form($form_values, $errors); ?>
		<input id="signupblog" type="hidden" name="signup_for" value="user" />
		<p class="submit"><input type="submit" name="submit" class="btn btn-default submit" value="<?php esc_attr_e('Submit', 'largo') ?>" /></p>
		<?php wp_nonce_field('largo_user_registration', 'largo_user_registration_nonce'); ?>
	</form>
	<?php
}

/**
 * Display user registration form
 *
 * @since 0.4
 *
 * @param string $user_login The entered username
 * @param string $user_email The entered email address
 * @param array $errors
 */
function largo_show_user_form($values=array(), $errors='') {
	extract($values);
?>
	<div class="form-group">
		<label for="user_login"><?php _e('Username', 'largo'); ?></label>
		<input name="user_login" type="text" id="user_login" value="<?php echo esc_attr($user_login); ?>" maxlength="60" />
	<?php if ($errmsg = $errors->get_error_message('user_login')) { ?>
		<p class="alert alert-error"><?php echo $errmsg; ?></p>
	<?php } ?>
	</div>

	<div class="form-group">
		<label for="user_email"><?php _e( 'Email&nbsp;address', 'largo' ) ?></label>
		<input name="user_email" type="text" id="user_email" value="<?php  echo esc_attr($user_email) ?>" maxlength="200" />
	<?php if ($errmsg = $errors->get_error_message('user_email') ) { ?>
		<p class="alert alert-error"><?php echo $errmsg ?></p>
	<?php } ?>
	</div>

	<div class="form-group">
		<label for="user_pass"><?php _e('Password', 'largo'); ?></label>
		<input name="user_pass" type="password" id="user_pass" value="" />
	<?php if ( $errmsg = $errors->get_error_message('user_pass') ) { ?>
		<p class="alert alert-error"><?php echo $errmsg; ?></p>
	<?php } ?>
	</div>

	<?php if ( $errmsg = $errors->get_error_message('generic') ) { ?>
		<p class="alert alert-error"><?php echo $errmsg; ?></p>
	<?php }

	/**
	 * Fires at the end of the user registration form on the site sign-up form.
	 *
	 * @since 0.4
	 *
	 * @param array $errors An array possibly containing 'user_login' or 'user_email' errors.
	 */
	do_action('largo_registration_extra_fields', $values, $errors);
	//do_action('signup_extra_fields', $errors);
}

/**
 * Validates Larog user registration fields.
 *
 * @since 0.4
 *
 * @uses apply_filters() largo_validate_user_signup_extra_fields to validate extra/custom signup
 * fields and return error messages when appropriate.
 */
function largo_validate_user_signup() {
	$result = wpmu_validate_user_signup($_POST['user_login'], $_POST['user_email']);
	extract($result);

	if (empty($_POST['user_pass'])) {
		if (empty($errors))
			$errors = new WP_Error();

		$errors->add('user_pass', __('Please enter a password.', 'largo'));
		$result['errors'] = $errors;
	}

	$extras = largo_registration_get_extra_fields($_POST);
	$result = array_merge($result, $extras);

	/**
	 * Fires at the end of the largo user signup validation.
	 *
	 * @since 0.4
	 *
	 * @param array $result An array of the original form values and any errors associated with them
	 * @param array $extras An array of any custom fields added to the registration form.
	 */
	$result = apply_filters('largo_validate_user_signup_extra_fields', $result, $extras);

	return $result;
}

/**
 * Processes the data from the user registration form, creating a new user
 *
 * @since 0.4
 *
 * @param array $postData All of the registration form's data from the $_POST variable
 */
function largo_process_registration_form($postData) {
	$defaults = largo_get_default_user_field_names();

	$userData = array();
	foreach ($defaults as $k => $v) {
		if (!empty($postData[$v]))
			$userData[$v] = $postData[$v];
	}

	// Create the user
	$userId = wp_insert_user($userData);

	// Set any extra fields as user meta
	if (!is_wp_error($userId)) {
		$extra_fields = largo_registration_get_extra_fields($postData);
		foreach ($extra_fields as $key => $value)
			update_user_meta($userId, $key, $value);
	}

	return $userId;
}

/**
 * Returns an array containing a list of the names of default fields for WordPress users.
 *
 * @since 0.4
 *
 * TODO: This might be better placed somewhere else as a general utility
 */
function largo_get_default_user_field_names() {
	global $wpdb;

	$results = $wpdb->get_results("DESCRIBE $wpdb->users");
	$fields = array_map(function($item) {
		return $item->Field;
	}, $results);

	return $fields;
}

/**
 * Separates the standard registration fields (user_login, user_email, user_pass) from any
 * custom fields that were submitted along with them. Returns the custom/extra fields as an
 * array.
 *
 * @since 0.4
 */
function largo_registration_get_extra_fields($postData) {
	$extras = $postData;
	$default_fields = array_merge(largo_get_default_user_field_names(), array(
		'user_login', 'user_email', 'user_pass',
		'signup_for', 'submit', 'signup_form_id', '_signup_form'
	));

	foreach ($postData as $k => $v) {
		if (in_array($k, $default_fields))
			unset($extras[$k]);
	}

	return $extras;
}

/**
 * Verify the Largo user registration form nonce field
 *
 * @since 0.4
 */
function largo_verify_user_registration_nonce() {
	if (!isset($_POST['largo_user_registration_nonce']) || !wp_verify_nonce($_POST['largo_user_registration_nonce'], 'largo_user_registration'))
		return false;
	else
		return true;
}

/**
 * Renders the Largo user registration form. Can be used as a shortcode: [largo_registration_form]
 *
 * @since 0.4
 */
function largo_registration_form() {
	// TODO use sprintf and __ for the success message
	$registerSuccessMessage = apply_filters(
		'largo_registration_success_message',
		'Thanks for registering! Login to ' . get_bloginfo('name') . ' by <a href="' . wp_login_url() . '">clicking here</a>.'
	);

	if (!is_user_logged_in()) {
		if (!empty($_POST)) {
			$proceed = largo_verify_user_registration_nonce();
			if (!$proceed) {
				echo '<div class="alert alert-error>' . _e('We were unable to verify the origin of your form submission.', 'largo') . '</div>';
				return false;
			}

			$form_values = largo_validate_user_signup($_POST['user_login'], $_POST['user_email']);
			$errors = $form_values['errors'];
			unset($form_values['errors']);

			if ($errors->get_error_code()) {
				largo_signup_user($form_values, $errors);
				return false;
			}

			$register = largo_process_registration_form($_POST);
			if (is_wp_error($register)) {
				largo_signup_user($form_values, $register);
			} else {
				echo '<div id="largo-registration-success-msg">' . $registerSuccessMessage . '</div>';
			}
		} else
			largo_signup_user();
	} else {
		// TODO use sprintf and __ for the logged in message
		$userLoggedInMessage = apply_filters(
			'largo_user_logged_in_message',
			'No need to register, you\'re already logged in. Continue to <a href="' . get_site_url() . '">' . get_bloginfo('name') . '</a>.'
		);
		echo '<div id="largo-user-logged-in-message">' . $userLoggedInMessage . '</div>';
	}
}
add_shortcode('largo_registration_form', 'largo_registration_form');

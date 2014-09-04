<?php

/**
 * Setup the new user signup process
 *
 * @since 0.4
 *
 * @uses apply_filters() filter $filtered_results
 * @uses largo_show_user_form() to display the user registration form
 * @param string $user_login The username
 * @param string $user_email The user's email
 * @param array $errors
 */
function largo_signup_user( $user_login = '', $user_email = '', $errors = '' ) {
	if ( !is_wp_error($errors) )
		$errors = new WP_Error();

	$signup_user_defaults = array(
		'user_login'  => $user_login,
		'user_email' => $user_email,
		'errors'     => $errors,
	);

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
	$filtered_results = apply_filters( 'signup_user_init', $signup_user_defaults );
	$user_login = $filtered_results['user_login'];
	$user_email = $filtered_results['user_email'];
	$errors = $filtered_results['errors'];
	?>
	<form id="setupform" method="post">
		<?php
		/** This action is documented in wp-signup.php */
		do_action( 'signup_hidden_fields', 'validate-user' );
		?>
		<?php largo_show_user_form($user_login, $user_email, $errors); ?>

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
function largo_show_user_form($user_login = '', $user_email = '', $errors = '') {
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
	do_action('signup_extra_fields', $errors);
}

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

	/**
	 * Fires at the end of the largo user signup validation.
	 *
	 * @since 0.4
	 *
	 * @param array $extras An array of any custom fields added to the registration form.
	 */
	do_action('largo_validate_user_signup_extra_fields', $extras);

	return $result;
}

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

function largo_get_default_user_field_names() {
	global $wpdb;

	$results = $wpdb->get_results("DESCRIBE $wpdb->users");
	$fields = array_map(function($item) {
		return $item->Field;
	}, $results);

	return $fields;
}

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

function largo_verify_user_registration_nonce() {
	if (!isset($_POST['largo_user_registration_nonce']) || !wp_verify_nonce($_POST['largo_user_registration_nonce'], 'largo_user_registration'))
		return false;
	else
		return true;
}

function largo_registration_form() {
	$proceed = largo_verify_user_registration_nonce();
	if (!$proceed) {
		'We were unable to verify the origin of your form submission.';
		return false;
	}

	$registerSuccessMessage = apply_filters(
		'largo_registration_success_message',
		'Thanks for registering! Login to ' . get_bloginfo('name') . ' by <a href="' . wp_login_url() . '">clicking here</a>.'
	);

	if (!is_user_logged_in()) {
		if (!empty($_POST)) {
			$result = largo_validate_user_signup($_POST['user_login'], $_POST['user_email']);
			extract($result);

			if ($errors->get_error_code()) {
				largo_signup_user($user_login, $user_email, $errors);
				return false;
			}

			$register = largo_process_registration_form($_POST);
			if (is_wp_error($register)) {
				var_log($register);
				largo_signup_user($user_login, $user_email, $register);
			} else {
				echo '<div id="largo-registration-success-msg">' . $registerSuccessMessage . '</div>';
			}
		} else
			largo_signup_user();
	} else {
		$userLoggedInMessage = apply_filters(
			'largo_user_logged_in_message',
			'No need to register, you\'re already logged in. Continue to <a href="' . get_site_url() . '">' . get_bloginfo('name') . '</a>.'
		);
		echo '<div id="largo-user-logged-in-message">' . $userLoggedInMessage . '</div>';
	}
}
add_shortcode('largo_registration_form', 'largo_registration_form');

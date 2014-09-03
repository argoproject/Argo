<?php

/**
 * Setup the new user signup process
 *
 * @since 0.4
 *
 * @uses apply_filters() filter $filtered_results
 * @uses largo_show_user_form() to display the user registration form
 * @param string $user_name The username
 * @param string $user_email The user's email
 * @param array $errors
 */
function largo_signup_user( $user_name = '', $user_email = '', $errors = '' ) {
	if ( !is_wp_error($errors) )
		$errors = new WP_Error();

	$signup_user_defaults = array(
		'user_name'  => $user_name,
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
	 *     @type string $user_name  The user username.
	 *     @type string $user_email The user email address.
	 *     @type array  $errors     An array of possible errors relevant to the sign-up user.
	 * }
	 */
	$filtered_results = apply_filters( 'signup_user_init', $signup_user_defaults );
	$user_name = $filtered_results['user_name'];
	$user_email = $filtered_results['user_email'];
	$errors = $filtered_results['errors'];
	?>
	<form id="setupform" method="post">
		<?php
		/** This action is documented in wp-signup.php */
		do_action( 'signup_hidden_fields', 'validate-user' );
		?>
		<?php largo_show_user_form($user_name, $user_email, $errors); ?>

		<input id="signupblog" type="hidden" name="signup_for" value="user" />
		<p class="submit"><input type="submit" name="submit" class="btn btn-default submit" value="<?php esc_attr_e('Submit', 'largo') ?>" /></p>
	</form>
	<?php
}

/**
 * Display user registration form
 *
 * @since 0.4
 *
 * @param string $user_name The entered username
 * @param string $user_email The entered email address
 * @param array $errors
 */
function largo_show_user_form($user_name = '', $user_email = '', $errors = '') {
?>
	<div class="form-group">
		<label for="user_name"><?php _e('Username', 'largo'); ?></label>
		<input name="user_name" type="text" id="user_name" value="<?php echo esc_attr($user_name); ?>" maxlength="60" />
	<?php if ($errmsg = $errors->get_error_message('user_name')) { ?>
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
	 * @param array $errors An array possibly containing 'user_name' or 'user_email' errors.
	 */
	do_action('signup_extra_fields', $errors);
}

function largo_validate_user_signup() {
	$result = wpmu_validate_user_signup($_POST['user_name'], $_POST['user_email']);
	extract($result);

	if (empty($_POST['user_pass'])) {
		if (empty($errors))
			$errors = new WP_Error();

		$errors->add('user_pass', __('Please enter a password.', 'largo'));
		$result['errors'] = $errors;
	}

	$extras = $_POST;
	$default_fields = array(
		'user_name', 'user_email', 'user_pass',
		'signup_for', 'submit', 'signup_form_id', '_signup_form'
	);

	foreach ($_POST as $k => $v) {
		if (in_array($k, $default_fields))
			unset($extras[$k]);
	}

	do_action('largo_validate_user_signup_extra_fields', $extras);

	return $result;
}

function largo_registration_form_shortcode() {
	if (!empty($_POST)) {
		$result = largo_validate_user_signup($_POST['user_name'], $_POST['user_email']);
		extract($result);

		if ($errors->get_error_code()) {
			largo_signup_user($user_name, $user_email, $errors);
			return false;
		}
	} else
		largo_signup_user();
}
add_shortcode('largo_registration_form', 'largo_registration_form_shortcode');

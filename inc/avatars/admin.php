<?php

// Changes to the user profile edit page
function largo_add_edit_form_multipart_encoding() {
	echo ' enctype="multipart/form-data"';
}
add_action('user_edit_form_tag', 'largo_add_edit_form_multipart_encoding');

function largo_add_avatar_field($user) {
?>
	<h3>Avatar</h3>

	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="<?php echo LARGO_AVATAR_INPUT_NAME; ?>"><?php _e('User avatar', 'largo'); ?></label></th>
				<td>
					<p><input type="file" name="<?php echo LARGO_AVATAR_INPUT_NAME; ?>" id="<?php echo LARGO_AVATAR_INPUT_NAME; ?>" /></p>
				</td>
			</tr>
		</tbody>
	</table>
<?php
}
add_action('edit_user_profile',  'largo_add_avatar_field');
add_action('show_user_profile',  'largo_add_avatar_field');

function largo_save_avatar_field($user_id) {
	if (has_files_to_upload(LARGO_AVATAR_INPUT_NAME)) {
		if (isset( $_FILES[LARGO_AVATAR_INPUT_NAME])) {
			$file = wp_upload_bits(
				$_FILES[LARGO_AVATAR_INPUT_NAME]['name'], null,
				@file_get_contents($_FILES[LARGO_AVATAR_INPUT_NAME]['tmp_name'])
			);

			if (FALSE === $file['error']) {
				$mime_type = wp_check_filetype($file['file']);
				$args = array(
					'guid' => $file['url'],
					'post_mime_type' => $mime_type['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['file'])),
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$id = wp_insert_attachment($args, $file['file']);

				if (!is_wp_error($id)) {
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					// Generate the metadata for the attachment, and update the database record.
					$metadata = wp_generate_attachment_metadata($id, $file['file']);
					$update = wp_update_attachment_metadata($id, $metadata);
					largo_associate_avatar_with_user($user_id, $id);
				}
			}
		}
	}
}
add_action('edit_user_profile_update', 'largo_save_avatar_field');
add_action('personal_options_update', 'largo_save_avatar_field');

// Utilities
function has_files_to_upload($id) {
	return (!empty($_FILES)) && isset($_FILES[$id]);
}

function largo_associate_avatar_with_user($user_id, $avatar_id) {
	return update_user_meta($user_id, LARGO_AVATAR_META_NAME, $avatar_id);
}

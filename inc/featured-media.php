<?php

if (!is_admin())
	return;

/**
 *
 */
function largo_featured_media_read() {
	if (!empty($_POST['data'])) {
		$data = json_decode(stripslashes($_POST['data']), true);
		$ret = get_post_meta($data['post_id'], 'featured_media', true);
		print json_encode($ret);
		wp_die();
	}
}
add_action('wp_ajax_largo_featured_media_read', 'largo_featured_media_read');

function largo_featured_media_save() {
	if (!empty($_POST['data'])) {
		$data = json_decode(stripslashes($_POST['data']), true);
		$post_id = $data['post_id'];
		unset($data['post_id']);
		update_post_meta($post_id, 'featured_media', $data);
		print json_encode($data);
		wp_die();
	}
}
add_action('wp_ajax_largo_featured_media_save', 'largo_featured_media_save');

/**
 * Returns the default available featured media types
 */
function largo_default_featured_media_types() {
	$media_types = apply_filters('largo_default_featured_media_types', array(
		'embed' => array(
			'title' => 'Embed code',
			'id' => sanitize_title('Embed code')
		),
		//'video' => array(
			//'title' => 'Video',
			//'id' => sanitize_title('Video')
		//),
		//'image' => array(
			//'title' => 'Image',
			//'id' => sanitize_title('Image')
		//),
		//'gallery' => array(
			//'title' => 'Photo gallery',
			//'id' => sanitize_title('Photo gallery')
		//)
	));
	return array_values($media_types);
}

/**
 * Enqueue the featured media javascript
 */
function largo_enqueue_featured_media_js($hook) {
	if (!in_array($hook, array('edit.php', 'post-new.php', 'post.php')))
		return;

	wp_enqueue_script(
		'largo_featured_media', get_template_directory_uri() . '/js/featured-media.js',
		array('media-models', 'media-views'), false, 1);

	wp_localize_script('largo_featured_media', 'LFM', array('options' => largo_default_featured_media_types()));
}
add_action('admin_enqueue_scripts', 'largo_enqueue_featured_media_js');

/**
 * Adds the "Set Featured Media" button above the post editor
 */
function largo_add_featured_media_button($context) {
	ob_start();
?>
	<a href="#" id="set-featured-media-button" class="button set-featured-media add_media" data-editor="content" title="Set Featured Media"><span class="wp-media-buttons-icon"></span> Set Featured Media</a>
<?php
	$context .= ob_get_contents();
	ob_end_clean();
	return $context;
}
add_action('media_buttons_context',  'largo_add_featured_media_button');

/**
 * Prints the templates used by featured media modal.
 */
function largo_featured_media_templates() { ?>
	<script type="text/template" id="tmpl-featured-media-frame">
		<div class="media-frame-menu"></div>
		<div class="media-frame-title"><h1>Set featured media</h1></div>
		<div class="media-frame-router"></div>
		<div class="media-frame-content"></div>
		<div class="media-frame-toolbar"></div>
		<div class="media-frame-uploader"></div>
	</script>

	<script type="text/template" id="tmpl-featured-media-save">
		<div class="media-toolbar-primary">
			<a href="#" class="button media-button button-primary button-large">Set as featured</a>
		</div>
	</script>

	<script type="text/template" id="tmpl-featured-media-options">
		<div class="media-menu">
		<# _.each(data.mediaTypes, function(type) { #>
			<a id="media-type-{{ type.id }}" class="media-menu-item" href="#">{{ type.title }}</a>
		<# }) #>
		</div>
	</script>

	<script type="text/template" id="tmpl-featured-embed-code">
		<form id="featured-embed-code-form">
			<div>
				<label for="title"><span>Title</span></label>
				<input type="text" name="title" <# if (typeof data.model !== 'undefined') { #>value="{{ data.model.get('title') }}"<# } #> />
			</div>

			<div>
				<label for="caption"><span>Caption</span></label>
				<input type="text" name="caption" <# if (typeof data.model !== 'undefined') { #>value="{{ data.model.get('caption') }}"<# } #> />
			</div>

			<div>
				<label for="credit"><span>Credit</span></label>
				<input type="text" name="credit" <# if (typeof data.model !== 'undefined') { #>value="{{ data.model.get('credit') }}"<# } #> />
			</div>

			<div>
				<label for="url"><span>URL</span></label>
				<input type="text" name="url" <# if (typeof data.model !== 'undefined') { #>value="{{ data.model.get('url') }}"<# } #> />
			</div>

			<div>
				<label for="embed"><span>Embed code</span></label>
				<textarea name="embed"><# if (typeof data.model !== 'undefined') { #>{{ data.model.get('embed') }}<# } #></textarea>
			</div>
		</form>
	</script>

	<script type="text/template" id="tmpl-featured-photo-gallery">
		TKTKTK
	</script>
<?php }
add_action('admin_print_footer_scripts', 'largo_featured_media_templates', 1);


function largo_featured_media_css() { ?>
	<style type="text/css">
		#featured-embed-code-form {
			margin: 20px;
		}
		#featured-embed-code-form div {
			margin: 0 0 20px 0;
		}
		#featured-embed-code-form label {
			clear: both;
			padding: 10px 0;
			margin: 0 0 10px 0;
		}
		#featured-embed-code-form label span {
			display: block;
			font-size: 18px;
			line-height: 22px;
			margin: 6px 0;
		}
		#featured-embed-code-form textarea,
		#featured-embed-code-form input {
			width: 100%;
			max-width: 700px;
		}
		#featured-embed-code-form textarea {
			min-height: 180px;
		}
	</style>
<?php }
add_action('admin_head', 'largo_featured_media_css', 1);

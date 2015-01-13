<?php

if (!is_admin())
	return;

/**
 * AJAX functions
 */
function largo_featured_media_read() {
	if (!empty($_POST['data'])) {
		$data = json_decode(stripslashes($_POST['data']), true);
		$ret = get_post_meta($data['id'], 'featured_media', true);
		if (empty($ret))
			print json_encode(array('id' => $data['id']));
		else
			print json_encode($ret);
		wp_die();
	}
}
add_action('wp_ajax_largo_featured_media_read', 'largo_featured_media_read');

function largo_featured_media_save() {
	if (!empty($_POST['data'])) {
		$data = json_decode(stripslashes($_POST['data']), true);
		$ret = update_post_meta($data['id'], 'featured_media', $data);
		print json_encode($data);
		wp_die();
	}
}
add_action('wp_ajax_largo_featured_media_save', 'largo_featured_media_save');

function largo_fetch_video_oembed() {
	if (!empty($_POST['data'])) {
		$data = json_decode(stripslashes($_POST['data']), true);
		$ret = wp_oembed_get($data['url']);
		print json_encode(array('embed' => $ret));
		wp_die();
	}
}
add_action('wp_ajax_largo_fetch_video_oembed', 'largo_fetch_video_oembed');

/**
 * Returns the default available featured media types
 */
function largo_default_featured_media_types() {
	$media_types = apply_filters('largo_default_featured_media_types', array(
		'embed' => array(
			'title' => 'Featured embed code',
			'id' => 'embed-code'
		),
		'video' => array(
			'title' => 'Featured video',
			'id' => 'video'
		),
		'image' => array(
			'title' => 'Featured image',
			'id' => 'image'
		),
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
		<div class="media-frame-router"><p>Choose an item to feature prominently at the top of your post.</p></div>
		<div class="media-frame-content"></div>
		<div class="media-frame-toolbar"></div>
		<div class="media-frame-uploader"></div>
	</script>

	<script type="text/template" id="tmpl-featured-media-save">
		<div class="media-toolbar-primary">
			<span class="spinner" style="display: none;"></span> <a href="#" class="button media-button button-primary button-large">Set as featured</a>
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
			<input type="hidden" name="type" value="embed-code" />

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

	<script type="text/template" id="tmpl-featured-video">
		<form id="featured-video-form">
			<input type="hidden" name="type" value="video" />

			<p>Enter a video URL to get started.</p>
			<div>
				<label for="url"><span>Video URL  <span class="spinner" style="display: none;"></span></label>
				<input type="text" class="url" name="url" <# if (typeof data.model !== 'undefined') { #>value="{{ data.model.get('url') }}"<# } #>/>
				<p class="error"></p>
			</div>

			<div>
				<label for="embed"><span>Video embed code</span></label>
				<textarea name="embed"><# if (typeof data.model !== 'undefined') { #>{{ data.model.get('embed') }}<# } #></textarea>
			</div>

			<div>
				<label for="title"><span>Title</span></span></label>
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

		</form>
	</script>
<?php }
add_action('admin_print_footer_scripts', 'largo_featured_media_templates', 1);


function largo_featured_media_css() { ?>
	<style type="text/css">
		.featured-media-modal form {
			margin: 20px;
		}
		.featured-media-modal form div {
			margin: 0 0 20px 0;
		}
		.featured-media-modal form label {
			clear: both;
			padding: 10px 0;
			margin: 0 0 10px 0;
		}
		.featured-media-modal form label span {
			display: block;
			font-size: 18px;
			line-height: 22px;
			margin: 6px 0;
		}
		.featured-media-modal form textarea,
		.featured-media-modal form input {
			width: 100%;
			max-width: 700px;
		}
		.featured-media-modal form textarea {
			min-height: 120px;
		}
		.featured-media-modal .media-frame-router p {
			margin: 0 0 0 15px;
		}
		.featured-media-modal .media-toolbar-primary span.spinner {
			display: inline-block;
			float: left;
			margin: 0;
			position: relative;
			top: 20px;
		}

		.featured-media-modal #featured-video-form label[for="url"] span.spinner {
			position: relative;
			top: 3px;
			float: none;
			margin: 0;
			display: inline-block;
		}
	</style>
<?php }
add_action('admin_head', 'largo_featured_media_css', 1);

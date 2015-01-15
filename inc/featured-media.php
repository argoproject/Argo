<?php

if (!is_admin())
	return;

/**
 * Template helpers
 */
function largo_get_featured_media($id) {
	return get_post_meta($id, 'featured_media', true);
}

function largo_has_featured_media($id) {
	$featured_media = largo_get_featured_media($id);
	return !empty($featured_media);
}

/**
 * AJAX functions
 */
function largo_featured_media_read() {
	if (!empty($_POST['data'])) {
		$data = json_decode(stripslashes($_POST['data']), true);
		$ret = get_post_meta($data['id'], 'featured_media', true);

		// Check if the post has a thumbnail/featured image set.
		// If yes, send that back as the featured media.
		$post_thumbnail = get_post_thumbnail_id($data['id']);
		if (empty($ret) && !empty($post_thumbnail)) {
			print json_encode(array(
				'id' => $data['id'],
				'attachment' => $post_thumbnail,
				'type' => 'image'
			));
			wp_die();
		}

		// Otherwise, check for `featured_media` post meta
		if (!empty($ret)) {
			print json_encode($ret);
			wp_die();
		}

		// No featured thumbnail and not `featured_media`, so just return
		// an array with the post ID
		print json_encode(array('id' => $data['id']));
		wp_die();
	}
}
add_action('wp_ajax_largo_featured_media_read', 'largo_featured_media_read');

function largo_featured_media_save() {
	if (!empty($_POST['data'])) {
		$data = json_decode(stripslashes($_POST['data']), true);

		// If an attachment ID is present, update the post thumbnail/featured image
		if (!empty($data['attachment']))
			set_post_thumbnail($data['id'], $data['attachment']);
		else
			delete_post_thumbnail($data['id']);

		// Save what's sent over the wire as `featured_media` post meta
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

function largo_remove_featured_image_meta_box() {
	remove_meta_box('postimagediv', 'post', 'normal');
	remove_meta_box('postimagediv', 'post', 'side');
	remove_meta_box('postimagediv', 'post', 'advanced');
}
add_action('do_meta_boxes', 'largo_remove_featured_image_meta_box');

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
		'gallery' => array(
			'title' => 'Featured photo gallery',
			'id' => 'gallery'
		)
	));
	return array_values($media_types);
}

if (defined('FEATURED_MEDIA') && FEATURED_MEDIA) {
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
		<script type="text/template" id="tmpl-featured-embed-code">
			<form id="featured-embed-code-form">
				<input type="hidden" name="type" value="embed-code" />

				<# var model = data.controller.model #>
				<div>
					<label for="title"><span>Title</span></label>
					<input type="text" name="title" <# if (typeof model !== 'undefined') { #>value="{{ model.get('title') }}"<# } #> />
				</div>

				<div>
					<label for="caption"><span>Caption</span></label>
					<input type="text" name="caption" <# if (typeof model !== 'undefined') { #>value="{{ model.get('caption') }}"<# } #> />
				</div>

				<div>
					<label for="credit"><span>Credit</span></label>
					<input type="text" name="credit" <# if (typeof model !== 'undefined') { #>value="{{ model.get('credit') }}"<# } #> />
				</div>

				<div>
					<label for="url"><span>URL</span></label>
					<input type="text" name="url" <# if (typeof model !== 'undefined') { #>value="{{ model.get('url') }}"<# } #> />
				</div>

				<div>
					<label for="embed"><span>Embed code</span></label>
					<textarea name="embed"><# if (typeof model !== 'undefined') { #>{{ model.get('embed') }}<# } #></textarea>
				</div>
			</form>
		</script>

		<script type="text/template" id="tmpl-featured-video">
			<form id="featured-video-form">
				<input type="hidden" name="type" value="video" />

				<p>Enter a video URL to get started.</p>
				<# var model = data.controller.model #>
				<div>
					<label for="url"><span>Video URL  <span class="spinner" style="display: none;"></span></label>
					<input type="text" class="url" name="url" <# if (typeof model !== 'undefined') { #>value="{{ model.get('url') }}"<# } #>/>
					<p class="error"></p>
				</div>

				<div>
					<label for="embed"><span>Video embed code</span></label>
					<textarea name="embed"><# if (typeof model !== 'undefined') { #>{{ model.get('embed') }}<# } #></textarea>
				</div>

				<div>
					<label for="title"><span>Title</span></span></label>
					<input type="text" name="title" <# if (typeof model !== 'undefined') { #>value="{{ model.get('title') }}"<# } #> />
				</div>

				<div>
					<label for="caption"><span>Caption</span></label>
					<input type="text" name="caption" <# if (typeof model !== 'undefined') { #>value="{{ model.get('caption') }}"<# } #> />
				</div>

				<div>
					<label for="credit"><span>Credit</span></label>
					<input type="text" name="credit" <# if (typeof model !== 'undefined') { #>value="{{ model.get('credit') }}"<# } #> />
				</div>

			</form>
		</script>
	<?php }
	add_action('admin_print_footer_scripts', 'largo_featured_media_templates', 1);


	function largo_featured_media_css() { ?>
		<style type="text/css">
			.featured-media-modal .featured-media-view form {
				margin: 20px;
			}
			.featured-media-modal .featured-media-view form div {
				margin: 0 0 20px 0;
			}
			.featured-media-modal .featured-media-view form label {
				clear: both;
				padding: 10px 0;
				margin: 0 0 10px 0;
			}
			.featured-media-modal .featured-media-view form label span {
				display: block;
				font-size: 18px;
				line-height: 22px;
				margin: 6px 0;
			}
			.featured-media-modal .featured-media-view form textarea,
			.featured-media-modal .featured-media-view form input {
				width: 100%;
				max-width: 700px;
			}
			.featured-media-modal .featured-media-view form textarea {
				min-height: 120px;
			}
			.featured-media-modal .featured-media-view .media-frame-router p {
				margin: 0 0 0 15px;
			}
			.featured-media-modal .featured-media-view .media-toolbar-primary span.spinner {
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
}

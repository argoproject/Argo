<?php

if (!is_admin())
	return;

/**
 *
 */
function largo_save_featured_media() {

}


/**
 * Returns the default available featured media types
 */
function largo_default_featured_media_types() {
	$media_types = apply_filters('largo_default_featured_media_types', array(
		'embed' => array(
			'title' => 'Embed code',
			'id' => sanitize_title('Embed code')
		),
		'video' => array(
			'title' => 'Video',
			'id' => sanitize_title('Video')
		),
		'image' => array(
			'title' => 'Image',
			'id' => sanitize_title('Image')
		),
		'gallery' => array(
			'title' => 'Photo gallery',
			'id' => sanitize_title('Photo gallery')
		)
	));
	return array_values($media_types);
}

/**
 * Enqueue the featured media javascript
 */
function largo_enqueue_featured_media_js($hook) {
	if (!in_array($hook, array('edit.php', 'post-new.php')))
		return;

	wp_enqueue_script(
		'largo_featured_media', get_template_directory_uri() . '/js/featured-media.js',
		array('media-models', 'media-views'), false, 1);

	wp_localize_script('largo_featured_media', 'LFM', largo_default_featured_media_types());
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
		<div class="media-frame-title"><h1>Select featured media</h1></div>
		<div class="media-frame-content"></div>
	</script>

	<script type="text/template" id="tmpl-featured-media-options">
		<div class="media-menu">
		<# data.mediaTypes.each(function(type) { #>
			<a id="media-type-{{ type.get('id') }}" class="media-menu-item" href="#">{{ type.get('title') }}</a>
		<# }) #>
		</div>
	</script>

	<script type="text/template" id="tmpl-featured-embed-code">
		<form id="featured-embed-code-form">
			<input type="text" name="featured-embed-code-title" />
			<input type="text" name="featured-embed-code-caption" />
			<input type="text" name="featured-embed-code-credit" />
			<textarea name="featured-embed-code-embed"></textarea>
		</form>
	</script>

	<script type="text/template" id="tmpl-featured-photo-gallery">
		TKTKTK
	</script>
<?php }
add_action('admin_print_footer_scripts', 'largo_featured_media_templates', 1);

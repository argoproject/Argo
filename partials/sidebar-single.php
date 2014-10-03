<?php
/**
 * For single post and pages
 */
$default_template = of_get_option('single_template');
$custom_template = get_post_meta($post->ID, '_wp_post_template', true);
$custom_sidebar = largo_get_custom_sidebar();

if ($custom_sidebar !== 'none') {
	dynamic_sidebar($custom_sidebar);

	# TODO: Should we really be trying this hard to display a sidebar?
	if ($custom_sidebar == 'sidebar-single' && !is_active_sidebar($custom_sidebar)) {
		if (!dynamic_sidebar('sidebar-main'))
			get_template_part('partials/sidebar', 'fallback');
	}
} else if (!dynamic_sidebar('sidebar-main')) {
	get_template_part('partials/sidebar', 'fallback');
}

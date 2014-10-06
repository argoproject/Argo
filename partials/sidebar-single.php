<?php
/**
 * For single post and pages
 */
$custom_sidebar = largo_get_custom_sidebar();
if ($custom_sidebar !== 'none') {
	dynamic_sidebar($custom_sidebar);

	if ($custom_sidebar == 'sidebar-single' && !is_active_sidebar($custom_sidebar)) {
		if (!dynamic_sidebar('sidebar-main'))
			get_template_part('partials/sidebar', 'fallback');
	}
} else if (!dynamic_sidebar('sidebar-main')) {
	get_template_part('partials/sidebar', 'fallback');
}

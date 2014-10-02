<?php
/**
 * For archive/taxonomy pages
 */

if ((is_archive() || is_tax()) && of_get_option('use_topic_sidebar') && is_active_sidebar('topic-sidebar'))
	dynamic_sidebar('topic-sidebar');
else {
	if (!dynamic_sidebar('sidebar-main'))
		get_template_part('partials/sidebar', 'fallback');
}

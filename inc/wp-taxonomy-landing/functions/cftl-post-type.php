<?php

/**
 * @package taxonomy-landing
 *
 * This file is part of Taxonomy Landing for WordPress
 * https://github.com/crowdfavorite/wp-taxonomy-landing
 *
 * Copyright (c) 2009-2012 Crowd Favorite, Ltd. All rights reserved.
 * http://crowdfavorite.com
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * **********************************************************************
 */

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

/**
 * Registers the taxonomy-landing custom post type
 */
function cftl_register_taxonomy_landing() {
	register_post_type('cftl-tax-landing', array(
		'labels' => array(
			'name' => __('Landing Pages', 'cf-tax-landing'),
			'singular_name' => __('Landing Page', 'cf-tax-landing'),
			'add_new' => _x('Add New', 'cftl-tax-landing', 'cf-tax-landing'),
			'add_new_item' => __('Add New Landing Page', 'cf-tax-landing'),
			'edit_item' => __('Edit Landing Page', 'cf-tax-landing'),
			'new_item' => __('New Landing Page', 'cf-tax-landing'),
			'all_items' => __('All Landing Pages', 'cf-tax-landing'),
			'view_item' => __('View Landing Page', 'cf-tax-landing'),
			'search_items' => __('Search Landing Pages', 'cf-tax-landing'),
			'not_found' =>  __('No Landing Pages found', 'cf-tax-landing'),
			'not_found_in_trash' => __('No Landing Pages found in Trash', 'cf-tax-landing'),
			'parent_item_colon' => '',
			'menu_name' => __('Landing Pages', 'cf-tax-landing')
		),
		'supports' => array(
			'title',
			'editor',
			'page-attributes',
			'thumbnail',
			'revisions',
		),
		'public' => false,
		'exclude_from_search' => true,
		'show_in_nav_menus' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'hierarchical' => true,
	));
}

add_action('init', 'cftl_register_taxonomy_landing');

/**
 * Remove Permalink display / edit controls
 */
function cfct_get_sample_permalink_html($return, $id, $new_title, $new_slug) {
	$post = get_post($id);
	if (!empty($post) && $post->post_type == 'cftl-tax-landing') {
		return '';
	}
	return $return;
}

add_filter('get_sample_permalink_html', 'cfct_get_sample_permalink_html', 10, 4);

/**
 * Remove Categories and Tags submenu items
 */
function cftl_remove_submenu_items() {
	global $wp_taxonomies;
	foreach ($wp_taxonomies as $tax) {
		remove_submenu_page('edit.php?post_type=cftl-tax-landing', 'edit-tags.php?taxonomy=' . $tax->name . '&amp;post_type=cftl-tax-landing');
	}
}

add_action('admin_menu', 'cftl_remove_submenu_items');

function cftl_register_taxonomies_to_tax_landing() {
	global $wp_taxonomies;
	foreach ($wp_taxonomies as $taxonomy) {
		register_taxonomy_for_object_type($taxonomy->name, 'cftl-tax-landing');
	}
}

add_action('init', 'cftl_register_taxonomies_to_tax_landing', 99999);

function cftl_register_taxonomy_landing_filter($types) {
	$types = array_merge($types, array('post', 'cftl-tax-landing'));
	return $types;
}

add_filter('cftl-build-enabled-post-types', 'cftl_register_taxonomy_landing_filter');

function cftl_set_tax_landing_title_admin($title) {
	global $post;
	if (!$post) {
		return $title;
	}
	if ($post->post_type != 'cftl-tax-landing' || !is_admin()) {
		return $title;
	}
	$title_array = array();
	foreach (get_the_taxonomies($post) as $tax_name => $tax_list) {
		$title_array[] = strip_tags($tax_list);
	}
	if (empty($title_array)) {
		return sprintf(__('%s - No specified taxonomies.', 'cf-tax-landing'), $title);
	}
	return $title . ' - ' . implode(' ', $title_array);
}

function cftl_set_tax_landing_title($title) {
	global $post, $cftl_tax_landing;
	if (!$post) {
		return $title;
	}
	if ($post->post_type != 'cftl-tax-landing') {
		return $title;
	}

	$substitutions = array(
		'[archives]' => __('Archives', 'cf-tax-landing'),
		'[tax-title]' => $cftl_tax_landing['original_title'],
		);
	$title = str_replace(array_keys($substitutions), array_values($substitutions), $title);

	return $title;
}

if (is_admin()) {
	add_filter('the_title', 'cftl_set_tax_landing_title_admin');
}
else {
	add_filter('the_title', 'cftl_set_tax_landing_title');
}

function cftl_tax_landing_messages($messages) {
	global $post;
	$taxonomy_array = get_the_taxonomies($post);
	if (!empty($taxonomy_array)) {
		$taxonomy_links = implode(' ', $taxonomy_array);
	}
	else {
		$taxonomy_links = __("No taxonomies specified.", 'cf-tax-landing');
	}

	$messages['cftl-tax-landing'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf(__('Landing Page updated.  %s', 'cf-tax-landing'), $taxonomy_links),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Landing Page updated.', 'cf-tax-landing'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf(__('Landing Page restored to revision from %s', 'cf-tax-landing'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
		6 => sprintf(__('Landing Page published.  %s', 'cf-tax-landing'), $taxonomy_links),
		7 => __('Landing Page saved.', 'cf-tax-landing'),
		8 => sprintf(__('Landing Page submitted.  %s', 'cf-tax-landing'), $taxonomy_links),
		9 => sprintf(__('Landing Page scheduled for: <strong>%1$s</strong>.', 'cf-tax-landing'),
			// translators: Publish box date format, see http://php.net/date
			date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date))),
		10 => sprintf(__('Landing Page updated.', 'cf-tax-landing')),
	);

	return $messages;
}

add_filter('post_updated_messages', 'cftl_tax_landing_messages');


function cftl_tax_landing_help($contextual_help, $screen_id, $screen) {
	// $contextual_help .= var_dump($screen); // use this to help determine $screen->id
	if ('cftl-tax-landing' == $screen->id) {
	$contextual_help =
		'<p>' . __('When adding or editing a Landing Page:', 'cf-tax-landing') . '</p>' .
		'<ul>' .
		'<li>' . __('Specify at least one category, tag, or custom taxonomy.') . '</li>' .
		'<li>' . __('When a taxonomy archive is requested, such as a category page, the first Landing Page with that taxonomy (if any) is used.') . '</li>' .
		'</ul>';
	}
	elseif ('edit-cftl-tax-landing' == $screen->id) {
		$contextual_help = '<p>' . __('Landing Pages are used to override the default category, tag, and custom Landing Pages with a Build-layout page.', 'cf-tax-landing') . '</p>';
	}
	return $contextual_help;
}
add_action('contextual_help', 'cftl_tax_landing_help', 10, 3);

function cftl_tax_landing_add_extras_box() {
	if (0 != count(get_page_templates())) {
		add_meta_box(
			'cftl_tax_landing_extras',
			__('Landing Page Details', 'cf-tax-landing'),
			'cftl_tax_landing_extras_box',
			'cftl-tax-landing',
			'side',
			'high'
		);
	}

	//remove various Largo meta boxes we don't need
	remove_meta_box('authordiv', 'cftl-tax-landing', 'normal|advanced|side');
	remove_meta_box('authordiv', 'cftl-tax-landing', 'normal|advanced|side');
	remove_meta_box('authordiv', 'cftl-tax-landing', 'normal|advanced|side');
	remove_meta_box('authordiv', 'cftl-tax-landing', 'normal|advanced|side');
	remove_meta_box('authordiv', 'cftl-tax-landing', 'normal|advanced|side');
	remove_meta_box('authordiv', 'cftl-tax-landing', 'normal|advanced|side');
	remove_meta_box('authordiv', 'cftl-tax-landing', 'normal|advanced|side');

}
add_action('add_meta_boxes', 'cftl_tax_landing_add_extras_box', 20);	//do this later so we can remove other meta boxes


function cftl_tax_landing_extras_box($post) {
	wp_nonce_field(plugin_basename(__FILE__), 'cftl_tax_landing_extras_nonce');

	$taxonomy_array = get_the_taxonomies($post);
	if (!empty($taxonomy_array)) {
		$taxonomy_links = implode('<br/>', $taxonomy_array);
	}
	else {
		$taxonomy_links = __("No taxonomies specified.", 'cf-tax-landing');
	}

	$page_template = get_post_meta($post->ID, '_wp_page_template', true);
	?>
<div class="form-field">
	<label for="cftl_page_template"><?php _e('Page Template', 'cf-tax-landing') ?></label>
	<select name="cftl_page_template" id="cftl_page_template">
		<option value=""<?php echo empty($page_template) ? ' selected="selected"' : '' ?>><?php _e('No Template (Use Post Templates)', 'cf-tax-landing'); ?></option>
		<option value="default"<?php echo ("default" == $page_template) ? ' selected="selected"' : ''?>><?php _e('Default (Page) Template', 'cf-tax-landing'); ?></option>
		<?php page_template_dropdown($page_template); ?>
	</select>
</div>
<div class="form-field">
	<label><?php _e('Current taxonomy links:', 'cf-tax-landing') ?></label><br/>
	<?php echo $taxonomy_links; ?>
</div>
<?php
}


function cftl_tax_landing_save_extras($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!isset($_POST['post_type']) || $_POST['post_type'] != 'cftl-tax-landing') {
		return;
	}

	if (!isset($_POST['cftl_tax_landing_extras_nonce']) || !wp_verify_nonce($_POST['cftl_tax_landing_extras_nonce'], plugin_basename(__FILE__))) {
		return;
	}


	if (!current_user_can('edit_post', $post_id)) {
		return;
	}
	$page_template = isset($_POST['cftl_page_template']) ? $_POST['cftl_page_template'] : null;
	$page_templates = get_page_templates();
	if (empty($page_template) || ('default' != $page_template && !in_array($page_template, $page_templates))) {

		delete_post_meta($post_id, '_wp_page_template');
	}
	else {
		update_post_meta($post_id, '_wp_page_template', $page_template);
	}
}


add_action('save_post', 'cftl_tax_landing_save_extras');

function cftl_post_type_link($post_link, $post) {
	if ($post->post_type != "cftl-tax-landing") {
		return $post_link;
	}
	$tax = get_object_taxonomies($post, 'object');
	$term = null;
	foreach ($tax as $label => $tax_obj) {
		$terms = get_object_term_cache($post->ID, $label);
		if (!empty($terms)) {
			$term = array_shift($terms);
			break;
		}
	}
	if (!empty($term)) {
		return get_term_link($term);
	}

	return $post_link;

}

add_filter('post_type_link', 'cftl_post_type_link', 10, 2);


/**
 * TO DO:
 * - remove unnecessary meta boxes
 * - add new meta boxes for controlling stuff
 * - implement JS, UX etc for controlling it
 * - build template file for display of it
 */
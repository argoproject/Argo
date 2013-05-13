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
 * Reorders posts according to custom order
 * Uses postmeta series_[termID]_order values
 */
function largo_series_custom_order ( $sql ) {
	global $wp_query, $opt, $wpdb;

	//only do this if we're a series page with sort order = custom
	if (is_array($opt) && $opt['post_order'] == 'custom' && $wp_query->query_vars['taxonomy'] == 'series') {

		//get the term ID to set the proper meta key
		$term_name = $wp_query->query_vars['term'];
		$term = get_term_by('slug', $term_name, 'series');
		$meta_key = 'series_' . $term->term_id . '_order';

		print_r($opt);

		//retool the query
		$sql['join'] = "INNER JOIN $wpdb->term_relationships ON (wpdb_posts.ID = wpdb_term_relationships.object_id)
	LEFT JOIN $wpdb->postmeta AS meta ON (wpdb_posts.ID = meta.post_id AND meta.meta_key = '{$meta_key}')";
		$sql['where'] = " AND ( wpdb_term_relationships.term_taxonomy_id IN (".$term->term_id.") ) AND wpdb_posts.post_type = 'post' AND (wpdb_posts.post_status = 'publish' OR wpdb_posts.post_status = 'private') ";
		$sql['orderby'] = "ISNULL(meta.meta_value+0) ASC, meta.meta_value+0 ASC, wpdb_posts.post_date DESC";
	}
	return $sql;
}
add_filter( 'posts_clauses', 'largo_series_custom_order');
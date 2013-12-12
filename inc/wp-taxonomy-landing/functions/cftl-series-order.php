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
function largo_series_custom_order ( $sql, $my_query ) {
	global $wpdb;

	//only do this if we're a series page
	if ( array_key_exists('taxonomy', $my_query->query_vars) && $my_query->query_vars['taxonomy'] == 'series' && array_key_exists('term',$my_query->query_vars)) :

		//get the term object to set the proper meta stuff and whatnot
		$term = get_term_by( 'slug', $my_query->query_vars['term'], 'series' );
		if ( ! $term ) $term = get_term_by( 'id', $my_query->query_vars['term'], 'series' );

		//custom sort order
		if ( $my_query->query_vars['orderby'] == 'series_custom' ) {

			$meta_key = 'series_' . $term->term_taxonomy_id . '_order';

			//retool the query
			$sql['join'] = "
				INNER JOIN $wpdb->term_relationships tr ON ($wpdb->posts.ID = tr.object_id)
				LEFT JOIN $wpdb->postmeta AS meta ON ($wpdb->posts.ID = meta.post_id AND meta.meta_key = '{$meta_key}')";
			$sql['where'] = "
				 AND ( tr.term_taxonomy_id IN (".$term->term_taxonomy_id.") )
				 AND $wpdb->posts.post_type = 'post'
				 AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private') ";
			$sql['orderby'] = "ISNULL(meta.meta_value+0) ASC, meta.meta_value+0 ASC, $wpdb->posts.post_date DESC";

		//featured stories first
		}  elseif ( strpos( $my_query->query_vars['orderby'], 'featured,' ) === 0 ) {

			list( $top, $sort ) = explode( " ", $my_query->query_vars['orderby'] );
			$top_term = get_term_by( 'slug', 'series-featured', 'prominence' );

			//retool the query
			$sql['join'] = "
				INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
				LEFT JOIN $wpdb->term_relationships t2 ON ($wpdb->posts.ID = t2.object_id)
				AND (t2.term_taxonomy_id = " . $top_term->term_taxonomy_id . ")";
			$sql['where'] = "
				AND ( $wpdb->term_relationships.term_taxonomy_id IN (".$term->term_taxonomy_id.") )
				AND $wpdb->posts.post_type = 'post'
				AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private') ";
			$sql['orderby'] = "ISNULL(t2.term_taxonomy_id) ASC, $wpdb->posts.post_date $sort";

		}

	endif;

	return $sql;

}
add_filter( 'posts_clauses', 'largo_series_custom_order', 10, 2);

/**
 * Helper function for getting posts in proper landing-page order for a series
 * @param integer series term id
 & @param inteter number of posts to fetch, defaults to all
 */
function largo_get_series_posts( $series_id, $number = -1 ) {

	// get the cf-tax-landing
	$args = array(
		'post_type' => 'cftl-tax-landing',
		'posts_per_page' => 1,
		'tax_query' => array( array(
			'taxonomy' => 'series',
			'field' => 'id',
			'terms' => $series_id
		)),
	);
	$landing = new WP_Query( $args );

	$series_args = array(
		'post_type' 		=> 'post',
		'taxonomy' => 'series',
		'term' 				=> $series_id,
		'order' 			=> 'DESC',
		'orderby' 		=> 'date',
		'posts_per_page' 	=> $number
	);

	if ( $landing->found_posts ) {
		$landing->next_post();
		$order = get_post_meta( $landing->post->ID, 'post_order', TRUE );
		switch ( $order ) {
			case 'ASC':
				$series_args['order'] = 'ASC';
				break;
			case 'custom':
				$series_args['orderby'] = 'series_custom';
				break;
			case 'featured, DESC':
			case 'featured, ASC':
				$series_args['orderby'] = $order;
				break;
		}
	}

	$series_posts = new WP_Query( $series_args );

	if ( $series_posts->found_posts ) return $series_posts;

	return false;

}
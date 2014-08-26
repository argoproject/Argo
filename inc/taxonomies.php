<?php

/**
 * Register the prominence and series custom taxonomies
 * Insert the default terms
 *
 * @since 1.0
 */
function largo_custom_taxonomies() {
    // SERIES
    if ( ! taxonomy_exists( 'series' ) ) {
        register_taxonomy( 'series', 'post', array(
            'hierarchical' 	=> true,
            'label' 		=> __('Series', 'largo'),
            'query_var' 	=> true,
            'rewrite' 		=> true,
        ) );
    }
}
add_action( 'init', 'largo_custom_taxonomies' );

/**
 * Determines whether a post is in a series
 * Expects to be called from within The Loop.
 *
 * @uses global $post
 * @return bool
 * @since 1.0
 */
function largo_post_in_series( $post_id = NULL ) {
  global $post;
  $the_id = ($post_id) ? $post_id : $post->ID ;
  $features = get_the_terms( $the_id, 'series' );
  return ( $features ) ? true : false;
}

/**
 * Outputs custom taxonomy terms attached to a post
 *
 * @return array of terms
 * @since 1.0
 */
function largo_custom_taxonomy_terms( $post_id ) {
	$taxonomies = apply_filters( 'largo_custom_taxonomies', array( 'series' ) );
	$post_terms = array();
	foreach ( $taxonomies as $tax ) {
		if ( taxonomy_exists( $tax ) ) {
			$terms = get_the_terms( $post_id, $tax );
			if ( $terms )
				$post_terms = array_merge( $post_terms, $terms );
		}
	}
	return $post_terms;
}

/**
 * Output format for the series custom taxonomy at the bottom of single posts
 *
 * @param $term array the term we want to output
 * @since 1.0
 */
if ( ! function_exists( 'largo_term_to_label' ) ) {
	function largo_term_to_label( $term ) {
	    return sprintf( '<div class="series-label"><h5><a href="%1$s">%2$s</a><a class="rss-link" href="%3$s"></a></h5><p>%4$s</p></div>',
	    	get_term_link( $term, $term->taxonomy ),
	    	esc_attr( $term->name ),
	    	get_term_feed_link( $term->term_id, $term->taxonomy ),
	    	esc_attr( strip_tags ( $term->description )
	    ));
	}
}

/**
 * Helper function for getting posts in proper landing-page order for a series
 * @param integer series term id
 * @param integer number of posts to fetch, defaults to all
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
		'tax_query' => array(
			array(
				'taxonomy' => 'series',
				'field' => 'id',
				'terms' => $series_id
			)
		),
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

/**
 * Helper for getting posts in a category archive, sorted by featured first
 */
function largo_category_archive_posts( $query ) {

	//don't muck with admin, non-categories, etc
	if ( !$query->is_category() || !$query->is_main_query() || is_admin() ) return;

	$category_post_ids = array();

	// get the featured posts
	$featured_posts = get_posts( array(
		'category_name' => $query->get('category_name'),
		'numberposts' => 5,
		'tax_query' => array(
			array(
				'taxonomy' => 'prominence',
				'field' => 'slug',
				'terms' => 'category-featured',
			)
		)
	));

	// get the IDs from the featured posts
	foreach ( $featured_posts as $fpost )
		$category_post_ids[] = $fpost->ID;

	// get the rest of the posts
	$plain_posts = get_posts( array(
		'category_name' => $query->get('category_name'),
		'nopaging' => true,
		'post__not_in' => $category_post_ids,
		)
	);

	// get the IDs from the plain posts
	foreach( $plain_posts as $ppost )
		$category_post_ids[] = $ppost->ID;

	//rewrite our main query to fetch these IDs
	//$query->set( 'category_name', NULL );
	$query->set( 'post__in', $category_post_ids );
	$query->set( 'orderby', 'post__in');
	$query->set( 'tax_query', NULL );
	$query->tax_query = NULL;	//unsetting it twice because WP is weird like that
}
add_action( 'pre_get_posts', 'largo_category_archive_posts', 15 );

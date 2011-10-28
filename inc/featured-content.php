<?php

/**
 * Show the 3 most recent featured posts in the page header
 *
 * @todo 3.1 rework to use multiple taxonomy queries.
 * @param   array   $args   Any WP_Query args
 * @return  object  WP_Query object
 */

function argo_tag_featured_post( $post_id, $post ) {
    $featured = wp_get_post_terms( $post_id, 'prominence' );
    if ( $featured ) {
        add_post_meta( $post_id, 'skybox', 'yes', true ) or 
            update_post_meta( $post_id, 'skybox', 'yes' );
    }
    else {
        delete_post_meta( $post_id, 'skybox' );
    }
}
add_action( 'publish_post', 'argo_tag_featured_post', 10, 2 );

function argo_get_featured_posts( $args = array() ) {
    $defaults = array( 
        'showposts' => 3,
        'offset' => 0,
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_key' => 'skybox',
        'meta_value' => 'yes',
        'ignore_sticky_posts' => 1,
    );
    $args = wp_parse_args( $args, $defaults );
    $skybox_query = new WP_Query( $args );
    return $skybox_query;
}

/**
 * If a post is marked as sticky, this unsticks any other posts on the blog 
 * so that we only have one sticky post at a time.
 *
 * If this ever breaks, #blamenacin.
 *
 * @param array $after new list of sticky posts
 * @param array $before original list of sticky posts
 * @return array
 */
function argo_scrub_sticky_posts( $after, $before ) {
    $newest_post_id = array_pop( $after );

    return array( $newest_post_id );
}
add_filter( 'pre_update_option_sticky_posts', 'argo_scrub_sticky_posts', 10, 2 );


/**
 * Determines whether a post has a "main" item from the feature custom 
 * taxonomy. Expects to be called from within The Loop.
 *
 * @uses global $post
 * @return bool
 */
function argo_post_has_features() {
    global $post;

    $features = get_the_terms( $post->ID, 'feature' );

    return ( $features ) ? true : false;
}

/**
 * Provides the "main" feature associated with a post.
 *
 * @uses global $post
 * @return term object|false
 */
function argo_get_the_main_feature() {
    global $post;

    $features = get_the_terms( $post->ID, 'feature' );

    if ( ! $features )
        return false;

    return array_shift( $features );
}

// add a link to an archive page for terms within the "featured" taxonomy to post meta.

if ( ! function_exists( 'argo_custom_taxonomy_terms' ) ) :
function argo_custom_taxonomy_terms( $post_id ) {
    global $CUSTOM_TAXONOMIES;
    $post_terms = array();
    foreach ( $CUSTOM_TAXONOMIES as $tax ) {
        if ( taxonomy_exists( $tax ) ) {
            $terms = get_the_terms( $post_id, $tax );
            if ( $terms ) {
                $post_terms = array_merge( $post_terms, $terms );
            }
        }
    }

    return $post_terms;
}
endif;

function argo_term_to_label( $term ) {
    return sprintf( '<li> <a href="%1$s">%2$s</a></li>',
                    get_term_link( $term, $term->taxonomy ), 
                    strtoupper( $term->name ) );
}

if ( ! function_exists( 'argo_the_post_labels' ) ) :
function argo_the_post_labels( $post_id ) {
    $post_terms = argo_custom_taxonomy_terms( $post_id );
    $all_labels = $post_terms;
    foreach ( $all_labels as $term ) {
        if ( strtolower( $term->name ) == 'featured' ) {
            continue;
        }
        echo argo_term_to_label( $term );
    }
}
endif;

//new to argo parent
if ( ! function_exists( 'argo_has_custom_taxonomy' ) ) :
	function argo_has_custom_taxonomy($post_id) {
		$argo_has_terms = argo_custom_taxonomy_terms( $post_id );
		if ($argo_has_terms) {
        	return true;
		}
    
		return false;
		}
endif;
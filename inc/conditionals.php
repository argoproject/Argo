<?php
/**
 * Various conditional checks for functionality that
 * Largo extends.
 * 
 * @since 0.5
 */

/**
 * Is this a series landing page?
 * 
 * @since 0.5
 * @see inc/wp-taxonomy-landing/*
 * 
 * @param int|WP_Post $post Optional. Post ID or post object. Default is global $post.
 * @return bool Whether the post is a series landing page.
 */
function largo_is_series_landing( $post ) {

	$post = get_post( $post );

	return ( $post->post_type == 'cftl-tax-landing' );

}

/**
 * Has a post been saved after it was created? (Has it been updated?)
 *
 * Can be used inside or outside the Loop.
 *
 * @link https://github.com/INN/Largo/issues/1259
 * @since 0.5.5
 * @param WP_Post|int|null $post The post
 * @return bool Whether or not the post has been updated
 */
function largo_post_was_updated( $post = null ) {
	$post = get_post( $post );

	$published = get_the_time( 'U', $post );
	$modified = get_the_modified_time( 'U', $post );
	return ( $published < $modified );
}

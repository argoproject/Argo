<?php

/**
 * Adds custom meta fields functionality to terms
 * Uses a custom post type as a proxy to bridge between a term_id and a post_meta field
 */

/**
 * Register the proxy post type
 */
function largo_register_term_meta_post_type() {
	register_post_type( '_term_meta', array(
		'public'     => false,
		'query_var'  => false,
		'rewrite'    => false,
		'supports'   => false,
	));
}
add_action( 'init', 'largo_register_term_meta_post_type' );

/**
 * Get the proxy post for a term
 *
 * @param string $taxnomy
 * @param int $term_id
 *
 * @return int $post_id
 */
function largo_get_term_meta_post( $taxonomy, $term_id ) {
	$query = new WP_Query( array(
		'post_type'      => '_term_meta',
		'posts_per_page' => 1,
		'post_status' => 'any',
		'tax_query'      => array(
			array(
				'taxonomy'         => $taxonomy,
				'field'            => 'id',
				'terms'            => $term_id,
				'include_children' => false
			)
		)
	));

	if ( $query->found_posts ) {
		return $query->posts[0]->ID;
	} else {
		$tax_input = array();
		$post_id = wp_insert_post( array( 'post_type' => '_term_meta', 'post_title' => "{$taxonomy}:${term_id}" ) );
		wp_set_post_terms( $post_id, array( (int) $term_id ), $taxonomy );
		return $post_id;
	}
}

/**
 * Get the featured media thumbnail for a term
 * @param int|WP_Post $post Required. Post ID or the term's class.
 * @param string $taxonomy Required, the taxonomy that the term is in.
 * @return string The HTML for the featured media, if it exists.
 *
 * @since 0.5.4
 * @uses largo-get_term_meta_post
 */
function largo_get_term_featured_media($term = null, $taxonomy = null) {
	$term = get_term($term, $taxonomy);
	$post_id = largo_get_term_meta_post( $taxonomy, $term->ID );
	$ret = largo_get_featured_media($post_id);

	return $ret;
}

/**
 * Add the "Set Featured Media" button in the term edit page
 *
 * @since 0.5.4
 * @see largo_term_featured_media_enqueue_post_editor
 */
function largo_add_term_featured_media_button( $context = '' ) {
	$has_featured_media = largo_has_featured_media($context->term_id);
	$language = (!empty($has_featured_media))? 'Edit' : 'Set';
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><?php _e('Term banner image', 'largo'); ?></th>
		<td>
			<p><a href="#" id="set-featured-media-button" class="button set-featured-media add_media" data-editor="content" title="<?php echo $language; ?> Featured Media"><span class="dashicons dashicons-admin-generic"></span> <?php echo $language; ?> Featured Media</a> <span class="spinner" style="display: none;"></span></p>
			<p class="description">This should have a default text</p>
			<?php echo largo_get_term_featured_media($context->term_id, $context->taxonomy); ?>
		</td>
	</tr>
	<?php
}
add_action( 'edit_category_form_fields', 'largo_add_term_featured_media_button');
add_action( 'edit_tag_form_fields', 'largo_add_term_featured_media_button');
add_action( $_REQUEST['taxonomy'].'_add_form_fields', 'largo_add_term_featured_media_button');

/**
 * Enqueue wordpress post editor on term edit page
 *
 * @param string $hook the page this is being called upon.
 * @since 0.5.4
 * @see largo_term_featured_media_button
 */
function largo_term_featured_media_enqueue_post_editor($hook) {
	if (!in_array($hook, array('edit.php', 'edit-tags.php')))
		return;

	wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'largo_term_featured_media_enqueue_post_editor', 1);

/**
 * Add meta data to a term
 *
 * @param string $taxonomy
 * @param int $term_id
 * @param string $meta_key
 * @param mixed $meta_value
 * @param bool $unique
 */
function largo_add_term_meta( $taxonomy, $term_id, $meta_key, $meta_value, $unique=false ) {
	$post_id = largo_get_term_meta_post( $taxonomy, $term_id );
	return add_post_meta( $post_id, $meta_key, $meta_value, $unique );
}

/**
 * Delete meta data to a term
 *
 * @param string $taxonomy
 * @param int $term_id
 * @param string $meta_key
 * @param mixed $meta_value
 */
function largo_delete_term_meta( $taxonomy, $term_id, $meta_key, $meta_value='' ) {
	$post_id = largo_get_term_meta_post( $taxonomy, $term_id );
	return delete_post_meta( $post_id, $meta_key, $meta_value );
}

/**
 * Get meta data to a term
 *
 * @param string $taxonomy
 * @param int $term_id
 * @param string $meta_key
 * @param bool $single
 */
function largo_get_term_meta( $taxonomy, $term_id, $meta_key, $single=false ) {
	$post_id = largo_get_term_meta_post( $taxonomy, $term_id );
	return get_post_meta( $post_id, $meta_key, $single );
}

/**
 * Update meta data to a term
 *
 * @param string $taxonomy
 * @param int $term_id
 * @param string $meta_key
 * @param mixed $meta_value
 * @param mixed $prev_value
 */
function largo_update_term_meta( $taxonomy, $term_id, $meta_key, $meta_value, $prev_value='' ) {
	$post_id = largo_get_term_meta_post( $taxonomy, $term_id );
	return update_post_meta( $post_id, $meta_key, $meta_value, $prev_value );
}

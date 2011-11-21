<?php

function argo_custom_taxonomies() {
    // PROMINENCE
    if ( ! taxonomy_exists( 'prominence' ) ) {
        register_taxonomy( 'prominence', 'post', array(
            'hierarchical' => true,
            'label' => 'Post Prominence',
            'query_var' => true,
            'rewrite' => true,
        ) );
        wp_insert_term( 'Featured', 'prominence' );
    }

    // FEATURES
    if ( ! taxonomy_exists( 'feature' ) ) {
        register_taxonomy( 'feature', 'post', array(
            'hierarchical' => true,
            'label' => 'Features',
            'query_var' => true,
            'rewrite' => true,
        ) );
    }
}
add_action( 'init', 'argo_custom_taxonomies' );
?>
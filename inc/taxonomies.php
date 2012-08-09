<?php

function largo_custom_taxonomies() {
    // PROMINENCE
    if ( ! taxonomy_exists( 'prominence' ) ) {
        register_taxonomy( 'prominence', 'post', array(
            'hierarchical' => true,
            'label' => 'Post Prominence',
            'query_var' => true,
            'rewrite' => true,
        ) );
        wp_insert_term( 'Homepage Featured', 'prominence' );
        wp_insert_term( 'Footer Featured Widget', 'prominence' );

        $parent_term = term_exists( 'Homepage Featured', 'prominence' );
        $parent_term_id = $parent_term['term_id'];
        wp_insert_term(
        	'Top Story', // the term
        	'prominence', // the taxonomy
        	array(
        		'parent'=> $parent_term_id
        	)
        );
    }

    // FEATURES
    if ( ! taxonomy_exists( 'series' ) ) {
        register_taxonomy( 'series', 'post', array(
            'hierarchical' => true,
            'label' => 'Series',
            'query_var' => true,
            'rewrite' => true,
        ) );
    }
}
add_action( 'init', 'largo_custom_taxonomies' );
?>
<?php

function largo_custom_taxonomies() {
    // PROMINENCE
    if ( ! taxonomy_exists( 'prominence' ) ) {
        register_taxonomy( 'prominence', 'post', array(
            'hierarchical' 	=> true,
            'label' 		=> __('Post Prominence', 'largo'),
            'query_var' 	=> true,
            'rewrite' 		=> true,
        ) );

        wp_insert_term(
        	__('Homepage Featured', 'largo'), 'prominence',
        	array(
        		'description' 	=> __('If you are using the Newspaper or Carousel optional homepage layout, add this label to posts to display them in the featured area on the homepage', 'largo'),
        		'slug' 			=> 'homepage-featured'
        	)
        );

        wp_insert_term(
        	__('Sidebar Featured Widget', 'largo'),	'prominence',
        	array(
        		'description' 	=> __('If you are using the Sidebar Featured Posts widget, add this label to posts to determine which to display in the widget', 'largo'),
        		'slug' 			=> 'sidebar-featured'
        	)
        );

        wp_insert_term(
        	__('Footer Featured Widget', 'largo'), 'prominence',
        	array(
        		'description' 	=> __('If you are using the Footer Featured Posts widget, add this label to posts to determine which to display in the widget', 'largo'),
        		'slug' 			=> 'footer-featured'
        	)
        );

        //check to make sure top story doesn't exist yet (for some reason it sometimes creates a duplicate term without this check) and then insert it
        $term = term_exists('Top Story', 'prominence');
        if ( $term == 0 || $term == null ) {
		    $parent_term = term_exists( 'Homepage Featured', 'prominence' );
		    $parent_term_id = $parent_term['term_id'];
		    wp_insert_term(
		    	__('Top Story', 'largo'), 'prominence',
		    	array(
		    		'parent'		=> $parent_term_id,
		    		'description' 	=> __('If you are using the Newspaper or Carousel optional homepage layout, add this label to a post to make it the top story on the homepage', 'largo'),
		    		'slug' 			=> 'homepage-featured-top-story' ) );
		}
    }

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

?>
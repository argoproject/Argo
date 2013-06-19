<?php

/**
 * Show related tags and subcategories for each main category
 * Used on category.php to display a list of related terms
 *
 * @since 1.0
 */

function largo_get_related_topics_for_category( $obj ) {
    $MAX_RELATED_TOPICS = 5;

    if (!isset($obj->post_type)) {
    	$obj->post_type = 0;
    }

    if ( $obj->post_type ) {
        if ( $obj->post_type == 'nav_menu_item' ) {
            $cat_id = $obj->object_id;
        }

    }else {
    $cat_id = $obj->cat_ID;
    }

    $out = "<ul>";

    // spit out the subcategories
    $cats = _subcategories_for_category( $cat_id );

    foreach ( $cats as $c ) {
        $out .= sprintf( '<li><a href="%s">%s</a></li>',
            get_category_link( $c->term_id ), $c->name
        );
    }

    if ( count( $cats ) < $MAX_RELATED_TOPICS ) {
        $tags = _tags_associated_with_category( $cat_id,
            $MAX_RELATED_TOPICS - count( $cats ) );

        foreach ( $tags as $t ) {
            $out .= sprintf( '<li><a href="%s">%s</a></li>',
                get_tag_link( $t->term_id ), $t->name
            );
        }
    }

    $out .= "</ul>";
    return $out;
}

function _tags_associated_with_category( $cat_id, $max = 5 ) {
    $query = new WP_Query( array(
        'posts_per_page' => -1,
        'cat' => $cat_id,
    ) );

    // Get a list of the tags used in posts in this category.
    $tags = array();
    $tag_objs = array();

    foreach ( $query->posts as $post ) {
        $ptags = get_the_tags( $post->ID );
        if ( $ptags ) {
            foreach ( $ptags as $tag ) {
                if (isset($tags[$tag->term_id])) {
                	$tags[ $tag->term_id ]++;
                } else {
                	$tags[ $tag->term_id ] = 0;
                }
                $tag_objs[ $tag->term_id ] = $tag;
            }
        }
    }

    // Sort the most popular and get the $max results, or all results
    // if max is -1
    arsort( $tags, SORT_NUMERIC );
    if ( $max == -1 ) {
        $tag_keys = array_keys( $tags );
    }
    else {
        $tag_keys = array_splice( array_keys( $tags ), 0, $max );
    }

    // Create an array of the selected tag objects
    $return_tags = array();
    foreach ( $tag_keys as $tk ) {
        array_push( $return_tags, $tag_objs[ $tk ] );
    }

    return $return_tags;
}

function _subcategories_for_category( $cat_id ) {
    // XXX: could also use get_term_children().  not sure which is better.
    $cats = get_categories( array(
        'child_of' => $cat_id,
    ) );

    return $cats;
}

/**
 * Provides topics (categories and tags) related to the current post in The
 * Loop.
 *
 * @param int $max The maximum number of topics to return.
 * @return array of term objects.
 * @since 1.0
 */
function largo_get_post_related_topics( $max = 5 ) {
    $cats = get_the_category();
    $tags = get_the_tags();

    $topics = array();
    if ( $cats ) {
        foreach ( $cats as $cat ) {
            if ( $cat->name == 'Uncategorized' ) {
                continue;
            }
            $posts = largo_get_recent_posts_for_term( $cat, 3, 2 );
            if ( $posts ) {
                $topics[] = $cat;
            }
        }
    }

    if ( $tags ) {
        foreach ( $tags as $tag ) {
            $posts = largo_get_recent_posts_for_term( $tag, 3, 2 );
            if ( $posts ) {
                $topics[] = $tag;
            }
        }
    }

    return array_slice( $topics, 0, $max );
}

/**
 * Provides the recent posts for a term object (category, post_tag, etc).
 * @uses global $post
 * @param object    $term   A term object.
 * @param int       $max    Maximum number of posts to return.
 * @param int       $min    Minimum number of posts. If not met, returns false.
 * @return array|false of post objects.
 * @since 1.0
 */
function largo_get_recent_posts_for_term( $term, $max = 5, $min = 1 ) {
    global $post;

    $query_args = array(
        'showposts' 			=> $max,
        'orderby' 				=> 'date',
        'order' 				=> 'DESC',
        'ignore_sticky_posts' 	=> 1,
    );

    // Exclude the current post if we're inside The Loop
    if ( $post ) {
        $query_args[ 'post__not_in' ] = array( $post->ID );
    }

    if ( $term->taxonomy == 'post_tag' ) {
        // have to use tag__in because tag_id doesn't seem to work.
        $query_args[ 'tag__in' ] = array( $term->term_id );
    }
    elseif ( $term->taxonomy == 'category' ) {
        $query_args[ 'cat' ] = $term->term_id;
    }
    elseif ( $term->taxonomy == 'series' ) {
        $query_args[ 'series' ] = $term->slug;
    }

    $query = new WP_Query( $query_args );

    if ( count( $query->posts ) < $min ) {
        return false;
    }

    return $query->posts;
}

/**
 * Determine if a post has either categories or tags
 *
 * @return bool true is a post has categories or tags
 * @since 1.0
 */
function largo_has_categories_or_tags() {
    if ( get_the_tags() ) {
        return true;
    }

    $cats = get_the_category();
    if ( $cats ) {
        foreach ( $cats as $cat ) {
            if ( $cat->name != 'Uncategorized' ) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Return (or echo) a list of categories and tags
 *
 * @param $max int number of categories and tags to return
 * @param $echo bool echo the output or return it (default: echo)
 * @param $link bool return the tags and category links or just the terms themselves
 * @param $use_icon bool include the tag icon or not (used on single.php)
 * @param $separator string to use as a separator between list items
 * @param $item_wrapper string html tag to use as a wrapper for elements in the output
 * @param $exclude array of term ids to exclude
 * @return array of category and tag links
 * @since 1.0
 * @todo consider prioritizing tags by popularity?
 */
if ( ! function_exists( 'largo_categories_and_tags' ) ) {
	function largo_categories_and_tags( $max = 5, $echo = true, $link = true, $use_icon = false, $separator = ', ', $item_wrapper = 'span', $exclude = array() ) {
	    $cats = get_the_category();
	    $tags = get_the_tags();
	    $icon = '';
	    $output = array();

	    // if $use_icon is true, include the markup for the tag icon
	    if ( $use_icon )
	    	$icon = '<i class="icon-white icon-tag"></i>';

	    if ( $cats ) {
	        foreach ( $cats as $cat ) {

	            // skip uncategorized and any others in the array of terms to exclude
	            if ( $cat->name == 'Uncategorized' || in_array( $cat->term_id, $exclude ) )
	                continue;

	            if ( $link ) {
		            $output[] = sprintf(
		                __('<%1$s class="post-category-link"><a href="%2$s" title="Read %3$s in the %4$s category">%5$s%4$s</a></%1$s>', 'largo'),
			                $item_wrapper,
			                get_category_link( $cat->term_id ),
			                of_get_option( 'posts_term_plural' ),
			                $cat->name,
			                $icon
		            );
		       } else {
			       $output[] = $cat->name;
		       }
	        }
	    }

	    if ( $tags ) {
	        foreach ( $tags as $tag ) {

	        	if ( in_array( $tag->term_id, $exclude ) )
	                continue;

	        	if ( $link ) {
		            $output[] = sprintf(
		                __('<%1$s class="post-tag-link"><a href="%2$s" title="Read %3$s tagged with: %4$s">%5$s%4$s</a></%1$s>', 'largo'),
		                	$item_wrapper,
		                	get_tag_link( $tag->term_id ),
		                	of_get_option( 'posts_term_plural' ),
		                	$tag->name,
		                	$icon
		            );
		         } else {
		         	 $output[] = $tag->name;
		       }
	        }
	    }

	    if ( $echo )
			echo implode( $separator, array_slice( $output, 0, $max ) );

		return $output;
	}
}

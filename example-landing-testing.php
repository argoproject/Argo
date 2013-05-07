<?php 
/**
 * Template Name: Landing Page Another Example
 * Description: Anohter example series landing page
 */

get_header(); ?>

<div id="content" class="span8" role="main">
	<?php the_post(); ?>
	<?php get_template_part( 'content', 'page' ); ?>
	<h3>Another example of a landing page template</h3>
	<hr>
<?php

global $wp_query;

if (isset($wp_query->query_vars['term']) && isset($wp_query->query_vars['taxonomy']) && $wp_query->query_vars['taxonomy'] == 'series') {

	$series = $wp_query->query_vars['term'];

	$old_query = $wp_query;

	//  assigning variables to the loop
	$args = array(
	    'post_type' => 'post',
	    'taxonomy' => 'series',
	    'term' => $series
	);

	$wp_query = new WP_Query($args);

	// and finally wind the posts back so we can go through the loop as usual

	while ( have_posts() ) : the_post();
		get_template_part( 'content', 'archive' );
	endwhile;

	largo_content_nav( 'nav-below' );

	$wp_query = $old_query;	
} ?>

</div><!-- /.grid_8 #content -->
<aside id="sidebar" class="span4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>

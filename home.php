<?php
get_header();

//collect post IDs in each loop so we can avoid duplicating posts
global $ids;
$ids = array();
?>

<div id="content" class="stories span8" role="main">

<?php
// get the optional homepage top section (if set)
if ( of_get_option('homepage_top') == 'topstories' ) {
	get_template_part( 'home-part-topstories' );
} else if ( of_get_option('homepage_top' ) == 'slider') {
	get_template_part( 'home-part-slider' );
}

// sticky posts box if this site uses it
if ( of_get_option( 'show_sticky_posts' ) ) {
	get_template_part( 'home-part-sticky-posts' );
}

// homepage bottom
if ( of_get_option('homepage_bottom') == 'widgets' ) {
	get_sidebar('homepage-bottom');
} else {
	$args = array(
		'paged'			=> $paged,
		'posts_per_page'=> 10,
		'post__not_in' 	=> $ids
		);
	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) : $query->the_post();
			//if the post is in the array of post IDs already on this page, skip it
			if ( in_array( get_the_ID(), $ids ) ) {
				continue;
			} else {
				$ids[] = get_the_ID();
				get_template_part( 'content', 'home' );
			}
		endwhile;
		largo_content_nav( 'nav-below' );
	} else {
		get_template_part( 'content', 'not-found' );
	}
}
?>

</div><!--/.grid_8 #content-->

<div id="sidebar" class="span4">
	<?php get_sidebar(); ?>
</div><!-- /.grid_4 -->
<?php get_footer(); ?>
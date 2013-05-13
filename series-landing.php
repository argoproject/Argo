<?php
/**
 * Template Name: Series Landing Page Default
 * Description: The default template for a series landing page. Many display options are set via admin.
 */
get_header();

// Load up our meta data and whatnot
the_post();
//make sure it's a landing page. If so, grab meta stuff
//if we're not a landing page, bail.

if ($post->post_type == 'cftl-tax-landing') {
	$opt = get_post_custom( $post->ID );
	foreach( $opt as $key => $val ) {
		$opt[ $key ] = $val[0];
	}
	$opt['show'] = maybe_unserialize($opt['show']);	//make this friendlier
	/**
	 * $opt will look like this:
	 *
	 *	Array (
	 *		[header_enabled] => boolean
	 *		[header_style] => standard|alternate
	 *		[cftl_layout] => one-column|two-column|three-column
	 *		[per_page] => integer|all
	 *		[post_order] => ASC|DESC|top, DESC|top, ASC
	 *		[footer_enabled] => boolean
	 *		[footerhtml] => {html}
	 *		[show] => array with boolean values for keys date|excerpt|author|image
	 *	)
	 *
	 * The post description is stored in 'excerpt' and the custom HTML header is the post content
	 */
}

// #content span width
$content_span = array('one-column' => 12, 'two-column' => 8, 'three-column' => 5);

?>

<?php // display left rail
if ($opt['cftl_layout'] == 'three-column') get_sidebar('series-left');
?>

<div id="content" class="span<?php echo $content_span[ $opt['cftl_layout'] ]; ?>" role="main">
	<?php get_template_part( 'content', 'page' ); ?>

<?php

global $wp_query;

// Make sure we're actually a series page, and pull posts accordingly
if (isset($wp_query->query_vars['term']) && isset($wp_query->query_vars['taxonomy']) && $wp_query->query_vars['taxonomy'] == 'series') {

	$series = $wp_query->query_vars['term'];
	$old_query = $wp_query;

	//default query args: by date, descending
	$args = array(
    'post_type' => 'post',
    'taxonomy' => 'series',
    'term' => $series,
    'order' => 'DESC',
  );

  //change args as needed
  if ($opt['post_order'] == 'ASC') $args['order'] = 'ASC';

  //other changes handled by filters from cftl-series-order.php

	//build the query
	$wp_query = new WP_Query($args);

	// and finally wind the posts back so we can go through the loop as usual
	while ( have_posts() ) : the_post();
		get_template_part( 'content', 'series' );
	endwhile;

	largo_content_nav( 'nav-below' );

	$wp_query = $old_query;
} ?>

</div><!-- /.grid_8 #content -->

<?php // display left rail
if ($opt['cftl_layout'] != 'one-column') : ?>
	<?php get_sidebar('series-right'); ?>
<?php endif; ?>

<!-- /.grid_4 -->
<?php get_footer(); ?>

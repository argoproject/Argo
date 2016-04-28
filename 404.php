<?php
/**
 * The template for displaying 404 pages.
 *
 * @package Largo
 * @since 0.1
 */
get_header(); ?>

<div id="content" class="span8" role="main">
	<?php get_template_part( 'partials/content', 'not-found' ); ?>
	<?php
		/*
		 * Display the Recent Posts widget
		 *
		 * @since 0.5.5
		 * @link https://codex.wordpress.org/Function_Reference/the_widget
		 */
		if ( class_exists( 'largo_recent_posts_widget' ) ) {
			the_widget( 'largo_recent_posts_widget', array (
				'title' => __( 'Or check out some of our recent stories', 'largo' ),
				'show_byline' => 1
			));
		}
	?>
</div><!--#content -->

<?php get_sidebar(); ?>
<?php get_footer();

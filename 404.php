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
	<p><?php
		echo wp_kses( of_get_option( '404_message' ), array(
			'a' => array(),
			'b' => array(),
			'br' => array(),
			'i' => array(),
			'em' => array(),
			'strong' => array(),
		));
	?></p>
	
	<h3><?php __( 'Or check out some of our most recent stories', 'largo' ); ?>
	<?php
		/*
		 * Display the Recent Posts widget
		 *
		 * @since 0.5.5
		 * @link http://jira.inn.org/browse/WE-103
		 * @link https://codex.wordpress.org/Function_Reference/the_widget
		 */
		if ( class_exists( 'largo_recent_posts_widget' ) ) {
			the_widget( 'largo_recent_posts_widget', array (
				'title' => ''	
			));
		}
	?>
</div><!--#content -->

<?php get_sidebar(); ?>
<?php get_footer();

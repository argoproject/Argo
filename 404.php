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
		echo wp_kses(of_get_option('404_message'), array(
			'a' => array(),
			'b' => array(),
			'br' => array(),
			'i' => array(),
			'em' => array(),
			'strong' => array(),
		));
	?></p>
</div><!--#content -->

<?php get_sidebar(); ?>
<?php get_footer();

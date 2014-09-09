<?php
/**
 * The template for displaying all pages.
 */
get_header();
?>

<div id="content" class="span8" role="main">
	<?php
		the_post();
		get_template_part( 'partials/content', 'page' );
	?>
</div><!-- #content -->

<?php get_sidebar( of_get_option( 'single_template' ) ); ?>
<?php get_footer(); ?>

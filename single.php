<?php
/**
 * The Template for displaying all single posts.
 */
get_header();
?>

<div id="content" class="span8" role="main">
	<?php
		while ( have_posts() ) : the_post();
			if ( of_get_option( 'single_template' ) == 'classic' ) {
				get_template_part( 'partials/content', 'single-classic' );
			} else {
				get_template_part( 'partials/content', 'single' );
			}

			if ( is_active_sidebar( 'article-bottom' ) ) {

				do_action( 'largo_before_post_bottom_widget_area' );

				echo '<div class="article-bottom">';
				dynamic_sidebar( 'article-bottom' );
				echo '</div>';

				do_action( 'largo_after_post_bottom_widget_area' );

			}

			do_action('largo_before_comments');

			comments_template( '', true );

			do_action('largo_after_comments');

		endwhile;
	?>
</div>

<?php do_action('largo_after_content'); ?>

<?php get_sidebar( of_get_option( 'single_template' ) ); ?>

<?php get_footer(); ?>

<?php
/**
 * The Template for displaying all single posts.
 */
get_header();
?>
<div>
<div id="content" class="span8" role="main">
	<?php
		while ( have_posts() ) : the_post();
			if ( of_get_option( 'single_template' ) == 'classic' ) {
				get_template_part( 'content', 'single-classic' );
			} else {
				get_template_part( 'content', 'single' );
			}

			if ( is_active_sidebar( 'article-bottom' ) && is_single() ){
				do_action('largo_before_sidebar_widgets');
				echo '<div class="article-bottom">';
				dynamic_sidebar( 'article-bottom' );
				echo '</div>';
				do_action('largo_after_sidebar_widgets');
			}

			comments_template( '', true );
		endwhile;
	?>
</div>
</div><!--#content-->

<?php get_sidebar( of_get_option( 'single_template' ) ); ?>
<?php get_footer(); ?>
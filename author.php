<?php
/**
 * The template for displaying Author pages.
 */

get_header(); ?>

		<div id="content" class="stories author-page span8" role="main">

		<?php if ( have_posts() ) { ?>

		<?php
			/* Queue the first post, that way we know
			* what author we're dealing with (if that is the case).
			*
			* We reset this later so we can run the loop
			* properly with a call to rewind_posts().
			*/
			the_post();
		?>

		<?php get_template_part( 'largo-author-box' ); ?>

		<h3 class="recent-posts clearfix"><?php _e('Recent posts', 'largo'); ?><a class="rss-link" href="<?php echo esc_url( get_author_feed_link( get_the_author_meta('ID') ) ); ?>"><i class="social-icons rss24"></i></a></h3>

				<?php
					/* Since we called the_post() above, we need to
					 * rewind the loop back to the beginning that way
					 * we can run the loop properly, in full.
					 */
					rewind_posts();
				?>

				<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'content', 'archive' );
					endwhile;
					largo_content_nav( 'nav-below' );

				} else {
					get_template_part( 'content', 'not-found' );
				}
				?>

			</div><!--/ #content .grid_8-->

<aside id="sidebar" class="span4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>
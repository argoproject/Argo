<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

		<div id="content" class="grid_8" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'single' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>
				<nav>
					<ul class="post-nav clearfix">
						<li class="n-post"><?php next_post_link( '<h5>Newer Post</h5> %link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link' ) . '</span>' ); ?></li>
						<li class="p-post"><?php previous_post_link( '<h5>Older Post</h5> %link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link' ) . '</span> %title' ); ?></li>
					</ul>
				</nav><!-- .post-nav -->

		</div><!--/.grid_8 #content-->

		<div id="sidebar" class="grid_4">
			<?php get_sidebar('single'); ?>
		</div><!-- /.grid_4 -->
<?php get_footer(); ?>
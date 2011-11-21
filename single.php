<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

		<div id="content" class="grid_8" role="main">

				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'single' );
					comments_template( '', true );
				endwhile; // end of the loop.
				?>
				<nav>
					<ul class="post-nav clearfix">
						<li class="n-post"><?php next_post_link( '<h5>Newer Post</h5> %link', '%title <span class="meta-nav">' . '&rarr;' . '</span>' ); ?></li>
						<li class="p-post"><?php previous_post_link( '<h5>Older Post</h5> %link', '<span class="meta-nav">' . '&larr;' . '</span> %title' ); ?></li>
					</ul>
				</nav><!-- .post-nav -->

		</div><!--/.grid_8 #content-->

		<div id="sidebar" class="grid_4">
			<?php get_sidebar('single'); ?>
		</div><!-- /.grid_4 -->
<?php get_footer(); ?>
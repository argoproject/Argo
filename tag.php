<?php
/**
 * The template used to display Tag Archive pages
 */

get_header(); ?>

		<div id="content" class="grid_8" role="main">
		
		<?php if ( have_posts() ) : ?>
			
			<p class="subscribe tag-subscribe"><a href="<?php echo get_term_feed_link( $tag->term_id, $tag->taxonomy ); ?>">Follow this topic</a></p>
			
			<h1 class="page-title"><?php single_tag_title(); ?></h1>

			<?php
				$tag_description = tag_description();
				if ( ! empty( $tag_description ) )
					echo apply_filters( 'tag_archive_meta', '<div class="topic-background">' . $tag_description . '</div>' );
			?>
			
			<h3 class="recent-posts">Recent posts</h3>
				
				<?php /* Start the Loop */ ?>
				
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content',  'tag' );
					?>

				<?php endwhile; ?>

				<?php argo_content_nav( 'nav-below' ); ?>
			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'argo' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'argo' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
					
				</article><!-- #post-0 -->

			<?php endif; ?>

		</div>
		<!-- /.grid_8 #content -->
<aside id="sidebar" class="grid_4">
<?php get_sidebar('topic'); ?>
<!-- /====== #ARGO add tag sidebar ========== -->
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>

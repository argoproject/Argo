<?php
/**
 * The template for displaying content type archives
 */

$term = $wp_query->get_queried_object();
?>

<?php  get_header();?>

		<div id="content" class="grid_8" role="main">

			<?php if ( have_posts() ) : ?>

			<div class="category-background">
				<p class="subscribe"><a href="<?php echo get_term_feed_link( $cat->term_id, $cat->taxonomy ); ?>">Follow this topic</a></p>
				<h1 class="page-title"><?php echo $term->name; ?></h1>

				<?php
					$termDescription = term_description( '', get_query_var( 'taxonomy' ) );
					if ( ! empty( $termDescription ) )
						echo apply_filters( 'term_archive_meta', '<div class="taxonomy-description">' . $termDescription . '</div>' );
				?>
			</div> <!-- /.category-background -->
			
			<h3 class="recent-posts">Recent posts</h3>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>				
				<?php 
				/* Run the loop for the category page to output the posts.
				* If you want to overload this in a child theme then include a file
				* called loop-category.php and that will be used instead.
				*/
				get_template_part( 'content', 'category' ); ?>

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
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>

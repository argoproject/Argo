<?php
/**
 * The template for displaying Search Results pages.
 */

get_header(); ?>

		<div id="content" class="grid_8" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="search-term"><?php _e('Your Search for', 'argo');?> '<?php the_search_query(); ?>' <?php _e('returned', 'argo');?> <strong><?php $NumResults = $wp_query->found_posts; echo $NumResults; ?> <?php _e('results', 'argo');?></strong></h1>
				</header>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'search' ); ?>
				<?php endwhile; ?>
    			<?php argo_pagination() ?>
				<!-- /.search-pagination -->

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'argo' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'argo' ); ?></p>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!--/.grid_8 #content-->

<div id="sidebar" class="grid_4">
<?php get_sidebar(); ?>
</div><!-- /.grid_4 -->
<?php get_footer(); ?>
<?php
/**
 * The template for displaying Category Archive pages.
 */

get_header(); ?>

		<div id="content" class="stories span8" role="main">

			<?php if ( have_posts() ) { ?>

			<header class="category-background clearfix">
				<h1 class="page-title"><?php single_cat_title(); ?></h1>
				<?php
					$category_description = category_description();
					if ( $category_description )
						echo '<div class="category-description">' . $category_description . '</div>';
				?>
				<?php if (largo_get_related_topics_for_category( get_queried_object() ) != '<ul></ul>' ) : ?>
					<div class="related-topics">
						<h5><?php _e('Related Topics:', 'largo'); ?> </h5>
						<?php echo largo_get_related_topics_for_category( get_queried_object() ); ?>
					</div> <!-- /.related-topics -->
				<?php endif; ?>

			</header> <!-- /.category-background -->

			<h3 class="recent-posts clearfix"><?php _e('Recent posts', 'largo'); ?><a class="rss-link" href="<?php echo esc_url( get_category_feed_link( get_queried_object_id() ) ); ?>"><i class="social-icons rss24"></i></a></h3>

				<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'content', 'category' );
					endwhile;
					largo_content_nav( 'nav-below' );

				} else {
					get_template_part( 'content', 'not-found' );
				}
				?>

		</div>
		<!-- /.grid_8 #content -->
<aside id="sidebar" class="span4">
<?php get_sidebar('topic'); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>

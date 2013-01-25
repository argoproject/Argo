<?php
/**
 * The template used to display Tag Archive pages
 */

get_header(); ?>

		<div id="content" class="stories span8" role="main">

		<?php if ( have_posts() ) { ?>
			<header class="category-background clearfix">

				<h1 class="page-title"><?php single_tag_title(); ?></h1>

				<?php
					$tag_description = tag_description();
					if ( $tag_description )
						echo '<div class="topic-background">' . $tag_description . '</div>';
				?>

			</header>

			<h3 class="recent-posts clearfix"><?php _e('Recent posts', 'largo'); ?><a class="rss-link" href="<?php echo esc_url( get_tag_feed_link( get_queried_object_id() ) ); ?>"><i class="icon-rss"></i></a></h3>

			<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'tag' );
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

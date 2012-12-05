<?php
/**
 * The template for displaying Search Results pages.
 */

get_header(); ?>

		<div id="content" class="stories search-results span8" role="main">

			<?php if ( have_posts() ) { ?>

				<?php get_search_form(); ?>

				<h3 class="recent-posts clearfix">Your search for <span class="search-term"><?php the_search_query(); ?></span> returned <?php printf( _n( '%s result', '%s results', $wp_query->found_posts ), number_format_i18n( $wp_query->found_posts ) ); ?></h3>

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'search' );
				endwhile;
    			largo_content_nav( 'nav-below' );
    		} else {
					get_template_part( 'content', 'not-found' );
			}
    		?>

			</div><!--/.grid_8 #content-->

<div id="sidebar" class="span4">
<?php get_sidebar(); ?>
</div><!-- /.grid_4 -->
<?php get_footer(); ?>
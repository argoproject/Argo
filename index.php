<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

			<div id="content" class="stories span8" role="main">

			<?php
			if ( have_posts() ) {
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'index' );
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
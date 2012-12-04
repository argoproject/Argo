<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

		<div id="content" class="stories span8" role="main">

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

				<header class="clearfix">
					<nav class="archive-dropdown">
						<select name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'><option value="">Select Month</option>
						<?php wp_get_archives( array('type' => 'monthly', 'format' => 'option' ) ); ?>
						</select>
					</nav>
				</header>

				<h3 class="recent-posts clearfix">
					<?php
						if ( is_month() ) {
							printf( 'Monthly Archives: <span>%s</span>', get_the_date('F Y') );
						} elseif ( is_year() ) {
							printf( 'Yearly Archives: <span>%s</span>', get_the_date('Y') );
						} else {
							echo 'Blog Archives';
						}
					?>
				</h3>

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
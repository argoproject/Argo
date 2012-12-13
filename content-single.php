<?php
/**
 * The template for displaying content in the single.php template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'hnews item' ); ?>>
	<header>
 		<h1 class="entry-title"><?php the_title(); ?></h1>
 		<h5 class="byline"><?php largo_byline(); ?> | <span class="comments-link"><?php comments_popup_link( __('Leave a Comment', 'largo'), __('<strong>1</strong> Comment ', 'largo'), __(' <strong>%</strong> Comments', 'largo') ); ?></span><?php edit_post_link( __('Edit This Post', 'largo'), ' | <span class="edit-link">', '</span>'); ?></h5>
 		<?php get_template_part( 'largo-social' ); ?>
	</header><!-- / entry header -->

	<div class="entry-content clearfix">
		<?php largo_entry_content( $post ); ?>
	</div><!-- .entry-content -->

	<footer class="post-meta bottom-meta">
 		<?php get_template_part( 'largo-social' ); ?>

 		<!-- Other posts in this series -->
 		<?php if ( largo_post_in_series() ): ?>
			<div class="labels clearfix">
            	<h5><?php _e('More In This Series', 'largo'); ?></h5>
            	<?php largo_the_series_list(); ?>
        	</div>
        <?php endif; ?>

        <!-- Post tags -->
        <?php if ( largo_has_categories_or_tags() ): ?>
    		<div class="tags clearfix">
    			<h5><?php _e('Filed Under:', 'largo'); ?></h5>
    			<ul>
    				<?php echo largo_the_categories_and_tags(); ?>
    			</ul>
    		</div>
    	<?php endif; ?>

		<!-- Author bio and social links -->
		<?php if ( largo_show_author_box() )
			get_template_part( 'largo-author-box' );
		?>

		<!-- Related posts -->
		<?php if ( of_get_option( 'show_related_content' ) )
			get_template_part( 'largo-related-posts' );
		?>


	</footer><!-- /.post-meta -->
</article><!-- #post-<?php the_ID(); ?> -->

<nav id="nav-below" class="pager post-nav clearfix">
	<div class="previous"><?php previous_post_link( __('<h5>Previous Story</h5> %link', 'largo'), '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'largo' ) . '</span> %title' ); ?></div>
	<div class="next"><?php next_post_link( __('<h5>Next Story</h5> %link', 'largo'), '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'largo' ) . '</span>' ); ?></div>
</nav><!-- #nav-below -->



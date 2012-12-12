<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<header>
 		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
 		<div class="post-meta">
 			<h5 class="byline"><?php largo_byline(); ?><?php edit_post_link( __('Edit This Post', 'largo'), ' | <span class="edit-link">', '</span>'); ?></h5>
 		</div>
	</header><!-- / entry header -->

	<div class="entry-content">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
		<?php largo_excerpt( $post, 5, true, __('Continue&nbsp;Reading&nbsp;&rarr;', 'largo') ); ?>
        <?php if ( largo_has_categories_or_tags() ): ?>
            <div class="post-meta bottom-meta">
    			<h5><strong><?php _e('Filed under:', 'largo'); ?></strong> <?php echo largo_homepage_categories_and_tags(); ?></h5>
            </div><!-- /.post-meta -->
        <?php endif; ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
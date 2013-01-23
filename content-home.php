<?php
/**
 * The template for displaying content in the main loop on the homepage
 */
 global $tags;
?>


<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<header>

 		<?php if ( largo_has_categories_or_tags() && $tags === 'top' ) : ?>
	 			<h5 class="top-tag"><?php largo_categories_and_tags(1); ?></h5>
	 	<?php endif; ?>

 		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

 		<h5 class="byline"><?php largo_byline(); ?><?php edit_post_link( __('Edit This Post', 'largo'), ' | <span class="edit-link">', '</span>'); ?></h5>

	</header><!-- / entry header -->

	<div class="entry-content">

		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

		<?php largo_excerpt( $post, 5, true, __('Continue&nbsp;Reading&nbsp;&rarr;', 'largo') ); ?>

        <?php if ( largo_has_categories_or_tags() && $tags === 'btm' ) : ?>
    			<h5 class="tag-list"><strong><?php _e('Filed under:', 'largo'); ?></strong> <?php largo_categories_and_tags(); ?></h5>
        <?php endif; ?>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
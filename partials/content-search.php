<?php
/*
 * The template for displaying the search partial.
 *
 * @package Largo
 */
$tags = of_get_option( 'tag_display' );
$values = get_post_custom( $post->ID );
$entry_classes = 'entry-content';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<div class="<?php echo $entry_classes; ?>">

		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to', 'largo' ) . ' ' ) )?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>

		<?php largo_excerpt( $post, 1, null, null, true, false ); ?>

		<?php if ( !is_home() && largo_has_categories_or_tags() && $tags === 'btm' ) { ?>
			<h5 class="tag-list"><strong><?php _e('More about:', 'largo'); ?></strong> <?php largo_categories_and_tags( 8 ); ?></h5>
		<?php } ?>
		<small class="date-link">
			<span class="date"><?php largo_time(); ?></span>
			<span class="sep">|</span>
			<a href="<?php the_permalink(); ?>" title="<?php the_permalink(); ?>" rel=""><?php the_permalink(); ?></a>
		</small>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->

<article id="post-<?php echo $featured_post->ID; ?>" <?php post_class('span3'); ?>>
	<?php if ( has_post_thumbnail($featured_post->ID) ) { ?>
		<div class="<?php largo_hero_class($featured_post->ID); ?>">
			<a href="<?php echo post_permalink($featured_post->ID); ?>">
				<?php echo get_the_post_thumbnail($featured_post->ID, 'rect_thumb'); ?>
			</a>
		</div>
	<?php } ?>

	<h2 class="entry-title">
		<a href="<?php echo post_permalink($featured_post->ID); ?>"
			title="<?php echo __( 'Permalink to', 'largo' ) . esc_attr(strip_tags($featured_post->post_title)); ?>"	
			rel="bookmark"><?php echo $featured_post->post_title; ?></a>
	</h2>
</article>

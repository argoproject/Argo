<div class="<?php echo $classes; ?>">
	<div class="embed-container">
		<?php echo $featured_media['embed']; ?>
	</div>
	<div class="embed-details wp-caption">
	<?php if (!empty($featured_media['credit'])) { ?>
		<p class='wp-media-credit featured-credit'><?php echo $featured_media['credit']; ?></p>
	<?php }

	if (!empty($featured_media['caption'])) { ?>
		<p class='wp-caption-text featured-caption'><?php echo $featured_media['caption']; ?></p>
	<?php } ?>
	</div>
</div>

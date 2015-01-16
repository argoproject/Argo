<?php
$hero_class = largo_hero_class($post->ID, false);
$values = get_post_custom($post->ID);

// If the box is checked to override the featured image display we'll treat the hero as if it was empty
// EXCEPT if a featured video is specified
if (isset($values['featured-image-display'][0]) && !isset($values['youtube_url']))
	$hero_class = 'is-empty';

if (largo_has_featured_media($post->ID)) {
	$featured_media = largo_get_featured_media($post->ID); ?>
	<div class="hero span12 <?php echo $hero_class; ?>">
		<?php if ($featured_media['type'] == 'embed-code') { ?>
			<div class="embed-container">
				<?php echo $featured_media['embed']; ?>
			</div>
		<?php } else if ($featured_media['type'] == 'video') { ?>
			<div class="embed-container">
				<?php echo $featured_media['embed'];
				if (!empty($featured_media['title'])) { echo '<p class="featured-title">' . $featured_media['title'] . "</p>"; }
				if (!empty($featured_media['caption'])) { echo '<p class="featured-caption">' . $featured_media['caption'] . "</p>"; }
				if (!empty($featured_media['credit'])) { echo '<p class="featured-credit">' . $featured_media['credit'] . "</p>"; }
				?>
			</div>
		<?php } else if ($featured_media['type'] == 'image') {
			largo_hero_with_caption($post->ID);
		} else if ($featured_media['type'] == 'gallery') {
			$ids = implode(',', $featured_media['gallery']); ?>
			<div class="featured-gallery">
				<?php echo gallery_shortcode(array('ids' => $ids)); ?>
			</div>
		<?php } ?>
		</div>
	</div>
<?php } else if ($hero_class != 'is-empty' && $youtube_url = $values['youtube_url'][0]) { ?>
	<div class="hero span12 <?php echo $hero_class; ?>">
		<div class="embed-container">
			<?php largo_youtube_iframe_from_url( $youtube_url ); ?>
		</div>
	</div>
<?php
}

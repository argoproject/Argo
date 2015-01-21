<?php
$hero_class = largo_hero_class($post->ID, false);
$values = get_post_custom($post->ID);

// If the box is checked to override the featured image display we'll treat the hero as if it was empty
// EXCEPT if a featured video is specified
if (isset($values['featured-image-display'][0]) && !isset($values['youtube_url']))
	$hero_class = 'is-empty';

if (largo_has_featured_media($post->ID) && $hero_class !== 'is-empty') {
	$featured_media = largo_get_featured_media($post->ID); ?>
	<div class="hero span12 <?php echo $hero_class; ?>">
		<?php if (in_array($featured_media['type'], array('embed-code', 'video'))) { ?>
			<div class="embed-container">
				<?php echo $featured_media['embed']; ?>
			</div>
			<div class="embed-details wp-caption"><?php
				if (!empty($featured_media['credit'])) { echo '<p class="wp-media-credit featured-credit">' . $featured_media['credit'] . "</p>"; }
	if (!empty($featured_media['caption'])) { echo '<p class="wp-caption-text featured-caption">' . $featured_media['caption'] . "</p>"; } ?>
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
<?php } else if ($hero_class != 'is-empty' && $youtube_url = $values['youtube_url'][0]) { ?>
	<div class="hero span12 <?php echo $hero_class; ?>">
		<div class="embed-container">
			<?php largo_youtube_iframe_from_url( $youtube_url ); ?>
		</div>
	</div>
<?php
}

<?php
/**
 * Home Template: Single
 * Description: Prominently features the top story by itself
 * Sidebars: Home Bottom Left | Home Bottom Center | Home Bottom Right
 * Right Rail: none
 */

$bigStoryPost = largo_home_single_top();
?>
<div id="homepage-featured" class="row-fluid clearfix">
	<div class="home-single span12">
		<?php echo $viewToggle; ?>
		<div class="home-top">
			<?php if ($has_video = get_post_meta($bigStoryPost->ID, 'youtube_url', true)) { ?>
				<div class="embed-container max-wide">
					<iframe src="http://www.youtube.com/embed/<?php echo substr(strrchr( $has_video, "="), 1 ); ?>?modestbranding=1"
						frameborder="0" allowfullscreen></iframe>
				</div>
			<?php } else { ?>
				<div class="full-hero">
					<a href="<?php echo esc_attr(get_permalink($bigStoryPost->ID)); ?>">
						<?php echo get_the_post_thumbnail($bigStoryPost->ID, 'full'); ?>
					</a>
				</div>
			<?php } ?>

			<div id="dark-top" <?php echo (!$has_video) ? 'class="overlay"' : ''; ?>>
				<div class="span10">
					<div class="row-fluid">
					<?php if (!empty($moreStories)) { ?>
						<div class="span8">
							<?php echo $bigStory; ?>
						</div>
						<div class="span4 side-articles">
							<?php echo $moreStories; ?>
						</div>
					<?php } else { ?>
						<?php echo $bigStory; ?>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

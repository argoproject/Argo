<?php
$post_states = largo_home_hero_side_series();
if (empty($post_states)) {
	$big_story = null;
	$series_stories = array();
	$featured_stories = array();
	$series_stories_term = null;
} else {
	extract($post_states); // $big_story, $series_stories, $featured_stories, $series_stories_term
}
?>
<div id="homepage-featured" class="row-fluid clearfix">
	<div class="home-single span12">
		<?php echo $viewToggle; // View toggle zone ?>
		<div class="home-top">
		<?php
		if ($has_video = get_post_meta($big_story->ID, 'youtube_url', true)) { ?>
			<div class="embed-container max-wide">
				<iframe src="<?php echo esc_url( 'http://www.youtube.com/embed/' . substr(strrchr( $has_video, "="), 1 ) . '?modestbranding=1' ); ?>"
					frameborder="0" allowfullscreen></iframe>
			</div>
		<?php } else { ?>
			<div class="full-hero one-third-width">
				<a href="<?php echo esc_url(get_permalink($big_story->ID)); ?>">
					<?php echo get_the_post_thumbnail($big_story->ID, 'third-full'); ?>
				</a>
			</div>
		<?php } ?>


			<div id="dark-top" <?php echo (!$has_video) ? 'class="overlay"' : ''; ?>>
				<div class="overlay-pane span8">
					<div class="row-fluid">
						<div class="span6">
							<?php echo $bigStory; ?>

							<?php if (!empty($series_stories)) { ?>
							<div class="series-stories">
								<h3><a href="<?php echo get_term_link( $series_stories_term ); ?>"><?php _e('Explore:', 'largo'); ?></a></h3>
								<ul>
								<?php foreach ($series_stories as $series_story) { ?>
									<li>
										<a href="<?php echo get_permalink($series_story->ID); ?>">
											<?php post_type_icon(array('id' => $series_story->ID)); ?><?php echo get_the_title($series_story->ID); ?>
										</a></h4>
									</li>
								<?php } ?>
								</ul>
							</div>
							<?php } ?>
						</div>

						<?php if (!empty($featured_stories)) { ?>
						<div class="span6 featured-stories">
							<?php foreach ($featured_stories as $featured_story) {
									setup_postdata($featured_story); ?>
							<article>
								<h5 class="top-tag"><?php largo_top_term(array('post' => $featured_story->ID)); ?></h5>
								<h4><a href="<?php echo get_permalink($featured_story->ID ); ?>"><?php echo get_the_title($featured_story->ID); ?></a></h4>
								<h5 class="byline"><?php _e('By', 'largo'); ?> <?php largo_author_link(true, $featured_story); ?></h5>
								<section>
									<?php largo_excerpt($featured_story, 2, true); ?>
								</section>
							</article>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div> <!-- End home-single -->
	</div>
</div>

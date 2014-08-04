<?php
$post_states = largo_home_get_single_featured_and_series();
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
			<div class="full-hero two-third-width">
				<a href="<?php echo esc_url(get_permalink($big_story->ID)); ?>">
					<?php echo get_the_post_thumbnail($big_story->ID, 'two-third-full'); ?>
				</a>
			</div>
		<?php } ?>


			<div id="dark-top" <?php echo (!$has_video) ? 'class="overlay"' : ''; ?>>
				<div class="overlay-pane span4">
					<div class="row-fluid">
						<div class="span12">
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
					</div>
				</div>
			</div>
		</div> <!-- End home-single -->
	</div>
</div>

<div id="home-secondary" class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span4">
				<?php dynamic_sidebar('home-bottom-left'); ?>
			</div>
			<div class="span4">
				<?php dynamic_sidebar('home-bottom-center'); ?>
			</div>
			<div class="span4">
				<?php dynamic_sidebar('home-bottom-right'); ?>
			</div>
		</div>
	</div>
</div>

<?php // The "river" content view ?>
<div id="home-river" class="row-fluid">
	<div class="span10 offset1">
		<h1><?php _e('Latest Stories', 'largo'); ?></h1>
		<?php
			//start at the beginning of the list
			rewind_posts();
			while (have_posts()) {
				the_post();
				get_template_part('content', 'river');
			}
			largo_content_nav('nav-below');
		?>
	</div>
</div>

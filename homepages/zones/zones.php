<?php

/**
 * Returns markup for the homepage view toggle
 **/
function homepage_view_toggle() {
	ob_start();
?>
	<aside id="view-format">
		<h1><?php _e('View', 'largo'); ?></h1>
		<ul>
			<li><a href="#" class="active" data-style="top">Top Stories</a></li>
			<li><a href="#" data-style="list">Recent stories</a></li>
	</aside>
<?php
	$ret = ob_get_contents();
	ob_end_clean();

	return $ret;
}

/**
 * Returns markup for the headline of the top story
 **/
function homepage_big_story_headline($moreLink=false) {
	$bigStoryPost = largo_home_single_top();
	ob_start();
?>
	<article>
		<h5 class="top-tag"><?php largo_top_term(array('post'=> $bigStoryPost->ID)); ?></h5>
		<h2><a href="<?php echo get_permalink($bigStoryPost->ID); ?>"><?php echo $bigStoryPost->post_title; ?></a></h2>
		<h5 class="byline"><?php largo_byline(true, true, $bigStoryPost); ?></h5>
		<section>
			<?php if (empty($moreLink)) {
					largo_excerpt($bigStoryPost, 2, false);
				} else {
					largo_excerpt($bigStoryPost, 2, true, __('Continue&nbsp;Reading&nbsp;&rarr;', 'largo'), true, false);
				} ?>
		</section>
	</article>
<?php
	wp_reset_postdata();
	$ret = ob_get_contents();
	ob_end_clean();
	return $ret;
}

/**
 * Returns a short list (3 posts) of stories in the same series as the main feature
 **/
function homepage_series_stories_list() {
	global $shown_ids;

	$feature = largo_get_the_main_feature();
	$series_posts = largo_get_recent_posts_for_term($feature, 3, 2);

	if (!empty($feature)) {
		ob_start();
?>
	<h5 class="top-tag"><a class="post-category-link" href="<?php echo get_term_link($feature); ?>">
		<?php echo esc_html($feature->name) ?></a></h5>
			<?php foreach ($series_posts as $series_post) {
				$shown_ids[] = $series_post->ID; ?>
				<h4 class="related-story"><a href="<?php echo esc_url(get_permalink($series_post->ID)); ?>">
					<?php echo get_the_title($series_post->ID); ?></a></h4>
			<?php } ?>
			<p class="more"><a href="<?php echo get_term_link($feature); ?>">
				<?php _e('Complete Coverage', 'largo'); ?></a></p>
<?php
	}
	$ret = ob_get_contents();
	ob_end_clean();
	return $ret;
}

function homepage_feature_stories_list() {
	global $shown_ids;

	ob_start();
	$featured_stories = largo_home_featured_stories();
	foreach ($featured_stories as $featured) {
		$shown_ids[] = $featured->ID;
?>
		<article class="featured-story">
			<h5 class="top-tag"><?php largo_top_term('post=' . $featured->ID); ?></h5>
			<h4 class="related-story"><a href="<?php echo esc_url(get_permalink($featured->ID)); ?>">
				<?php echo $featured->post_title; ?></a></h4>
		</article>
<?php
	}
	$ret = ob_get_contents();
	ob_end_clean();
	return $ret;
}

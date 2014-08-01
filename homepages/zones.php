<?php

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

function homepage_big_story_headline() {
	$big_story = largo_home_single_top();

	ob_start();
if($has_video = get_post_meta($big_story->ID, 'youtube_url', true)) { ?>
	<div class="embed-container max-wide">
		<iframe src="http://www.youtube.com/embed/<?php echo substr(strrchr( $has_video, "="), 1 ); ?>?modestbranding=1"
			frameborder="0" allowfullscreen></iframe>
	</div>
<?php } else { ?>
	<div class="full-hero"><a href="<?php echo esc_attr( get_permalink( $big_story->ID ) ); ?>"><?php echo get_the_post_thumbnail( $big_story->ID, 'full' ); ?></a></div>
<?php }

	$ret = ob_get_contents();
	ob_end_clean();
	return $ret;
}

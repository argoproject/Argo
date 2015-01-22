<?php
/**
 * The homepage template
 */
get_header();

/*
 * Collect post IDs in each loop so we can avoid duplicating posts
 * and get the theme option to determine if this is a two column or three column layout
 */
$tags = of_get_option('tag_display');
?>

<div id="content" class="stories span8 three-col" role="main">

	<div id="content-main" class="span8">

	<?php
	// get the optional homepage top section (if set)
	if (of_get_option('homepage_top') === 'topstories')
		get_template_part('partials/home-topstories');

	// sticky posts box if this site uses it
	if (of_get_option('show_sticky_posts'))
		get_template_part('partials/sticky-posts');

	// bottom section, we'll either use a two-column widget area or a single column list of recent posts
	if (of_get_option('homepage_bottom') === 'widgets') {
		get_template_part('partials/home', 'bottom-widget-area');
	} else {
		get_template_part('partials/home-post-list');
	} ?>
	</div>

	<div id="left-rail" class="span4">
	<?php if (!dynamic_sidebar('homepage-left-rail')) { ?>
		<p><?php _e('Please add widgets to this content area in the WordPress admin area under appearance > widgets.', 'largo'); ?></p>
	<?php } ?>
	</div>
</div><!-- #content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

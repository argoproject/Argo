<?php
/*
 * Widget area that appears at the very bottom of the homepage, before the footer.
 *
 * @package Largo
 */
global $layout, $wp_query;

// Because this template displays no posts, and because some widgets (Largo Recent Posts) will draw from $wp_query->posts to supplement $shown_ids, we're going to temporarily zero that out.
// @see https://github.com/INN/Largo/pull/1150
// @see commit 4443b3047b8e64856978b0b378c2f8a3ba9ebc7c
$preserve = $wp_query->posts;
$wp_query->posts = array();
?>
<div id="homepage-bottom" class="clearfix">
<?php if ( ! dynamic_sidebar( 'homepage-bottom' ) ) : ?>
	<p><?php _e('Please add widgets to this content area in the WordPress admin area under appearance > widgets.', 'largo'); ?></p>
<?php endif; ?>
</div>
<?php

$wp_query->posts = $preserve;

<?php
$apologies = __('Apologies, but no results were found. Perhaps searching will help.', 'largo');

if ( is_404() ) {
	$apologies = sprintf(
		__("Apologies, but <code>%s</code> was not found. Perhaps wearching will help.", 'largo'),
		wp_kses($_SERVER['REQUEST_URI'], array()) // The url
	);
}

?>
<article id="post-0" class="post no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e('Nothing Found', 'largo'); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<p><?php echo $apologies; ?></p>
		<?php get_search_form(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-0 -->

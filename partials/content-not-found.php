<?php
$apologies = __( 'Apologies, but no results were found. Perhaps searching will help.', 'largo' );

if ( is_404() ) {
	if ( of_get_option( '404_message' ) ) {
		$apologies = wp_kses( of_get_option( '404_message' ), array(
			'a' => array(),
			'b' => array(),
			'br' => array(),
			'i' => array(),
			'em' => array(),
			'strong' => array(),
		));
	} else {
		$apologies = sprintf(
			__( 'Apologies, but <code>%s</code> was not found. Perhaps searching will help.', 'largo' ),
			wp_kses($_SERVER['REQUEST_URI'], array()) // The url, sanitized
		);
	}
} else if ( is_search() ) {
	$apologies = __( 'Apologies, but no results were found. Perhaps searching for something else will help.', 'largo');
}

?>
<article id="post-0" class="post no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Page Not Found', 'largo' ); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<p><?php echo $apologies; ?></p>
		<?php get_search_form(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-0 -->

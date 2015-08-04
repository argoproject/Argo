<?php
/**
 * The Footer widget areas.
 */
$layout = of_get_option('footer_layout');
?>

<div id="supplementary" class="row-fluid <?php echo $layout ?>">
	<?php
	// If the specified template does not exist in the child or parent theme, use 3col-default
	if ( locate_template( 'partials/footer-widget-' . $layout . '.php' ) == '' ) {
		$layout = '3col-default';
	}

	get_template_part( 'partials/footer-widget', $layout);
	?>

</div>

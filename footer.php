<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 */
?>
	</div> <!-- #main -->

</div><!-- #page -->

<?php
	if ( is_active_sidebar( 'before-footer' ) ) {
		get_template_part( 'partials/footer', 'before-footer-widget-area' );
	}

	do_action( 'largo_before_footer' );
?>

<div class="footer-bg clearfix">
	<footer id="site-footer">

		<?php
			do_action( 'largo_before_footer_widgets' );

			get_template_part( 'partials/footer', 'widget-area' );

			do_action( 'largo_before_footer_boilerplate' );

			get_template_part( 'partials/footer', 'boilerplate' );

			do_action( 'largo_before_footer_close' );
		?>

	</footer>
</div>

<?php
	do_action( 'largo_after_footer' );

	get_template_part( 'partials/footer', 'sticky' );

	wp_footer();
?>

</body>
</html>

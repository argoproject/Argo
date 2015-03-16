<div id="boilerplate" class="row-fluid clearfix">

	<p class="copyright"><?php largo_copyright_message(); ?></p>

	<?php largo_nav_menu(
		array(
			'theme_location' => 'footer-bottom',
			'container' => false,
			'depth' => 1
		) );
	?>

	<div class="footer-bottom clearfix">

		<!-- If you enjoy this theme and use it on a production site we would appreciate it if you would leave the credit in place. Thanks :) -->
		<p class="footer-credit">
		<?php printf( __('This site built with <a href="%s">Project Largo</a> from <a href="%s">INN</a> and proudly powered by <a href="%s" rel="nofollow">WordPress</a>.', 'largo'),
				'http://largoproject.org',
				'http://inn.org',
				'http://wordpress.org'
			 );
		?>
		</p>

		<p class="back-to-top"><a href="#top"><?php _e('Back to top', 'largo'); ?> &uarr;</a></p>

	</div>

</div>

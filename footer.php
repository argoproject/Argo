<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 */
?>

	</div> <!-- #main .container_12 -->

	<div id="site-footer" class="clearfix">
		<footer>
			<div id="supplementary" class="container_12">

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				get_sidebar( 'footer' );
			?>
				
				<div id="boilerplate" class="grid_12">
				    <p><?php argo_copyright_message(); ?></p>
				    <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1  ) ); ?>
					<p class="back-to-top"><a href="#page">Back to top &uarr;</a></p>
				</div><!-- /#boilerplate -->
				
			</div><!-- /.container_12 -->
		</footer>
	</div><!-- #site-footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
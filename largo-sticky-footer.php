<?php if( is_single() ): ?>
<div class="sticky-footer-holder">
	<div class="sticky-footer-container">

		<?php // Share the post using the ShareThis API. The class *_custom gives us a blank slate. ?>
		<div class="share"><h4>Share</h4>
			<span class="st_facebook_custom icon-facebook share-button"></span>
			<span class="st_twitter_custom icon-twitter share-button"></span>
			<span class="st_email_custom icon-mail share-button"></span>
		</div>

		<?php // Comment link ?>
		<?php if ( comments_open() ): ?>
		<div class="comments">
			<a href="<?php comments_link(); ?>">Comment <i class="icon-comment"></i></a>
		</div>
		<?php endif; ?>

		<?php // The category RSS and author follow links ?>
		<?php
		// Get the category object
		$post_categories = wp_get_post_categories( $wp_query->post->ID );
		if ( !empty( $post_categories ) ) {
			$first_category = get_category( array_shift($post_categories));

			// Skip the default 'Uncategorized' category
			if ( $first_category->name == 'Uncategorized' ) {
				$first_category = get_category( array_shift($post_categories) );
			}

			// Make sure we have an actual category
			if ( is_wp_error($first_category) ) {
				$first_category = null;
			}
		}

		// Get the author object
		$author = get_userdata( get_the_author_meta( 'ID' ) );
		$byline_text = get_post_meta( $post->ID, 'largo_byline_text' ) ? esc_attr( get_post_meta( $wp_query->post->ID, 'largo_byline_text', true ) ) : '';
		// If the byline override is being used, then don't use it
		if ( !empty($byline_text) ) {
			$author = null;
		}
		
		if ( !empty($author) || !empty($first_category) ): ?>
		<div class="follow">
			<h4>Follow</h4>

			<?php
				if ( $first_category ) {
					echo '<a class="icon-rss" href="', get_category_feed_link( $first_category->cat_ID ), '">',esc_html($first_category->name),'</a>';
			} ?>

				<?php if ( $author ): ?>
				<div class="follow-author">
					<a href="<?php echo get_author_feed_link($author->ID); ?>" class="icon-rss"></a>
					<?php if ( $twitter = get_the_author_meta( 'twitter', $author->ID ) ) : ?>
						<a href="<?php echo esc_url( $twitter ); ?>" class="icon-twitter"></a>
					<?php endif; ?>

					<a href="<?php echo get_author_posts_url( $author->ID ); ?>"><?php echo esc_html( $author->display_name ); ?></a>
				</div>
				<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
<?php

if ( $rel_topics = largo_get_post_related_topics( 6 ) ) : ?>

	<div id="related-posts" class="idTabs row-fluid clearfix">
		<ul id="related-post-nav" class="span4">
			<li><h5><?php _e('More About', 'largo'); ?></h5></li>
			<?php
				foreach ( $rel_topics as $count => $topic ) {
					echo '<li><a href="#rp' . $count . '">' . $topic->name . '</a></li>';
				}
			?>
		</ul>

		<div class="related-items span8">
			<?php foreach ( $rel_topics as $count => $topic ):
				$rel_posts = largo_get_recent_posts_for_term( $topic, 3 ); ?>
				<div id="rp<?php echo $count; ?>">
					<ul>
					<?php
						// the top related post
						$top_post = array_shift( $rel_posts ); ?>
						<li class="top-related clearfix">
						<?php
							$permalink = get_permalink( $top_post->ID );
							$post_title = $top_post->post_title;
							echo '<h3><a href="' . $permalink . '" title="Read: ' . $post_title . '">' . $post_title . '</a></h3>';
							if ( get_the_post_thumbnail( $top_post->ID ) )
								echo '<a href="' . $permalink . '"/>' . get_the_post_thumbnail( $top_post->ID, '60x60' ) . '</a>';
							if ($top_post->post_excerpt) {
								echo '<p>' . $top_post->post_excerpt . '</p>';
							} else {
								echo '<p>' . largo_trim_sentences($top_post->post_content, 2) . '</p>';
							}
						?>
						</li>
						<?php
						// the other related posts
						foreach ( $rel_posts as $rel_post ) {
							echo '<li><a href="' . esc_url( get_permalink( $rel_post->ID ) ) . '" title="' . esc_attr($topic->name) . '">' . $rel_post->post_title . '</a></li>';
						}
						?>
					</ul>

					<p><a href="<?php echo esc_url( get_term_link( $topic ) ); ?>" title="<?php echo esc_attr($topic->name); ?>" target="_blank"><strong><?php printf( __('View all %1$s %2$s &rarr;', 'largo'), $topic->name, of_get_option( 'posts_term_plural' ) ); ?></strong></a></p>
				</div> <!-- /#rpX -->
			<?php endforeach; ?>
		</div> <!-- /.items -->
	</div> <!-- /#related-posts -->
<?php

endif; // if ( $rel_topics )
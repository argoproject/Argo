<?php
/*
 * Author Bio Widget
 */
class largo_author_widget extends WP_Widget {

	function largo_author_widget() {
		$widget_ops = array(
			'classname' 	=> 'largo-author',
			'description'	=> __('Show the author bio in a widget', 'largo')
		);
		$this->WP_Widget( 'largo-author-widget', __('Largo Author Bio', 'largo'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$authors = array();
		$bios = '';

		if( is_singular() || is_author() ):

				if ( is_singular() ) {
					if ( function_exists( 'get_coauthors' ) ) {
						$authors = get_coauthors( get_queried_object_id() );
					} else {
						$authors = array( get_user_by( 'id', get_queried_object()->post_author ) );
					}
				} else if ( is_author() ) {
					$authors = array( get_queried_object() );
				}

				// make sure we have at least one bio before we show the widget
				foreach ( $authors as $key => $author ) {
					$bio = trim( $author->description );
					if ( !is_author() && empty( $bio ) ) {
						unset( $authors[$key] );
					} else {
						$bios .= $bio;
					}
				}
				if ( !is_author() && empty( $bios ) ) {
					return;
				}

				echo $before_widget;

				// BEGIN what used to be in largo-author-box.php

				foreach( $authors as $author ) {
				?>

				<div class="author-box author vcard clearfix">
					<?php
						// Author name
						if ( is_author() ) {
							echo '<h1 class="fn n">' . $author->display_name . '</h1>';
						} else {
							printf( __( '<h3 class="widgettitle">About <span class="fn n"><a class="url" href="/author/%1$s/" rel="author" title="See all posts by %1$s">%2$s</a></span></h3>', 'largo' ),
								$author->user_login,
								esc_attr( $author->display_name )
							);
						}

						// Avatar
						if ( largo_has_gravatar( $author->user_email ) ) {
							echo '<div class="photo">' . get_avatar( $author->ID, 96, '', $author->display_name ) . '</div>';
						} elseif ( $author->type == 'guest-author' && get_the_post_thumbnail( $author->ID ) ) {
							$photo = get_the_post_thumbnail( $author->ID, array( 96,96 ) );
							$photo = str_replace( 'attachment-96x96 wp-post-image', 'avatar avatar-96 photo', $photo );
							echo '<div class="photo">' . $photo . '</div>';
						}

						// Description
						if ( $author->description ) {
							echo '<p>' . esc_attr( $author->description ) . '</p>';
						}
					?>

					<ul class="social-links">
						<?php if ( $fb = $author->fb ) { ?>
							<li class="facebook">
								<div class="fb-subscribe" data-href="<?php echo esc_url( $fb ); ?>" data-layout="button_count" data-show-faces="false" data-width="225"></div>
							</li>
						<?php } ?>

						<?php if ( $twitter = $author->twitter ) { ?>
							<li class="twitter">
								<a href="https://twitter.com/<?php echo largo_twitter_url_to_username ( $twitter ); ?>" class="twitter-follow-button" data-show-count="false"><?php printf( __('Follow @%1$s', 'largo'), largo_twitter_url_to_username ( $twitter ) ); ?></a>
							</li>
						<?php } ?>

						<?php if ( $email = $author->user_email ) { ?>
							<li class="email">
								<a href="mailto:<?php echo esc_attr( $email ); ?>" title="e-mail <?php echo esc_attr( $author->display_name ); ?>"><i class="icon-mail"></i></a>
							</li>
						<?php } ?>

						<?php if ( $googleplus = $author->googleplus ) { ?>
							<li class="gplus">
								<a href="<?php echo esc_url( $googleplus ); ?>" title="<?php echo esc_attr( $author->display_name ); ?> on Google+" rel="me"><i class="icon-gplus"></i></a>
							</li>
						<?php } ?>

						<?php if ( $linkedin = $author->linkedin ) { ?>
							<li class="linkedin">
								<a href="<?php echo esc_url( $linkedin ); ?>" title="<?php echo esc_attr( $author->display_name ); ?> on LinkedIn"><i class="icon-linkedin"></i></a>
							</li>
						<?php } ?>

						<?php
							if ( !is_author() ) {
								printf( __( '<li class="author-posts-link"><a class="url" href="/author/%1$s/" rel="author" title="See all posts by %1$s">More by %2$s</a></li>', 'largo' ),
									$author->user_login,
									esc_attr( $author->first_name )
								);
							}
						?>
					</ul>

				</div>

				<?php }  // foreach
				// END what used to be in largo-author-box.php

				echo $after_widget;
		else:
			_e( 'Not a valid author context' );
		endif;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}
}

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

		echo $before_widget;

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

				foreach( $authors as $author_obj ) {
					$ctx = array('author_obj' => $author_obj); ?>

				<div class="author-box author vcard clearfix">
					<?php largo_render_template('partials/author-bio', 'description', $ctx); ?>
					<?php largo_render_template('partials/author-bio', 'social-links', $ctx); ?>
				</div>

				<?php }  // foreach
		else:
			_e( 'Not a valid author context' );
		endif;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}
}

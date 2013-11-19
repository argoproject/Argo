<?php
/*
 * List all of the terms in a custom taxonomy
 */
class largo_related_posts_simple extends WP_Widget {

	function largo_related_posts_simple() {
		$widget_ops = array(
			'classname' 	=> 'largo-related-simple',
			'description' 	=> __('Lists posts related to the current post', 'largo')
		);
		$this->WP_Widget( 'largo-related-simgple', __('Largo Related Posts (simple)', 'largo'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		// only useful on post pages
		if ( !is_single() ) return;

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Read Next', 'largo' ) : $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;




		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['quantity'] = (int) $new_instance['quantity'];
		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$quantity = $instance['quantity'] : 1;
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'largo' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p>
			<label for="<?php echo $this->get_field_id('quantity'); ?>"><?php _e('Number of Posts to Display:', 'largo'); ?></label>
			<select name="<?php echo $this->get_field_id('quantity'); ?>">
			<?php
			for ($i = 1; $i < 6; $i++) {
				echo '<option value="', $i, selected($quantity, $i), '">', $i, '</option>';
			} ?>
			</select>
			<div class="description">It's best to keep this at just one.</div>
		</p>

	<?php
	}

}

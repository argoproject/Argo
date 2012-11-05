<?php
/*
 * A simple Twitter widget
 */
class largo_facebook_widget extends WP_Widget {

	function largo_facebook_widget() {
		$widget_ops = array(
			'classname' 	=> 'largo-facebook',
			'description' 	=> 'Show a Facebook Like Box for your page'
		);
		$this->WP_Widget( 'largo-facebook-widget', __('Largo Facebook Widget', 'largo-facebook'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$widget_class = !empty($instance['widget_class']) ? $instance['widget_class'] : '';
		if ($instance['hidden_desktop'] === 1)
			$widget_class .= ' hidden-desktop';
		if ($instance['hidden_tablet'] === 1)
			$widget_class .= ' hidden-tablet';
		if ($instance['hidden_phone'] === 1)
			$widget_class .= ' hidden-phone';
		/* Add the widget class to $before_widget, used as a style hook */
		if( strpos($before_widget, 'class') === false ) {
			$before_widget = str_replace('>', 'class="'. $widget_class . '"', $before_widget);
		}
		else {
			$before_widget = str_replace('class="', 'class="'. $widget_class . ' ', $before_widget);
		}

		echo $before_widget;

			 $output = '<div class="fb-like-box" data-href="' . $instance['fb_page_url'] . '" data-height="' . $instance['widget-height'] . '"';
			 $output .= $instance['show_faces'] === 1 ? ' data-show-faces="true"' : ' data-show-faces="false"';
			 $output .= $instance['show_stream'] === 1 ? ' data-stream="true"' : ' data-stream="false"';
			 $output .= $instance['show_header'] === 1 ? ' data-header="true"' : ' data-header="false"';
			 $output .= '></div>';

		echo $output;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['fb_page_url'] = strip_tags( $new_instance['fb_page_url'] );
		$instance['widget_height'] = strip_tags( $new_instance['widget_height'] );
		$instance['show_faces'] = $new_instance['show_faces'] ? 1 : 0;
		$instance['show_stream'] = $new_instance['show_stream'] ? 1 : 0;
		$instance['show_header'] = $new_instance['show_header'] ? 1 : 0;
		$instance['widget_class'] = $new_instance['widget_class'];
		$instance['hidden_desktop'] = $new_instance['hidden_desktop'] ? 1 : 0;
		$instance['hidden_tablet'] = $new_instance['hidden_tablet'] ? 1 : 0;
		$instance['hidden_phone'] = $new_instance['hidden_phone'] ? 1 : 0;
		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'fb_page_url' 		=> of_get_option( 'facebook_link' ),
			'widget_height' 	=> 350,
			'show_faces' 		=> 1,
			'show_stream' 		=> 0,
			'show_header' 		=> 0,
			'widget_class' 		=> 'default',
			'hidden_desktop' 	=> '',
			'hidden_tablet' 	=> '',
			'hidden_phone'		=> ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$show_faces = $instance['show_faces'] ? 'checked="checked"' : '';
		$show_stream = $instance['show_stream'] ? 'checked="checked"' : '';
		$show_header = $instance['show_header'] ? 'checked="checked"' : '';
		$desktop = $instance['hidden_desktop'] ? 'checked="checked"' : '';
		$tablet = $instance['hidden_tablet'] ? 'checked="checked"' : '';
		$phone = $instance['hidden_phone'] ? 'checked="checked"' : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'fb_page_url' ); ?>"><?php _e('Facebook Page URL:', 'largo-facebook'); ?></label>
			<input id="<?php echo $this->get_field_id( 'fb_page_url' ); ?>" name="<?php echo $this->get_field_name( 'fb_page_url' ); ?>" value="<?php echo $instance['fb_page_url']; ?>" style="width:90%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'widget_height' ); ?>"><?php _e('Widget Height:', 'largo-facebook'); ?></label>
			<input id="<?php echo $this->get_field_id( 'widget_height' ); ?>" name="<?php echo $this->get_field_name( 'widget_height' ); ?>" value="<?php echo $instance['widget_height']; ?>" style="width:90%;" />
		</p>

		<p style="margin:15px 0 10px 5px">
			<input class="checkbox" type="checkbox" <?php echo $show_faces; ?> id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" /> <label for="<?php echo $this->get_field_id('show_faces'); ?>"><?php _e('Show Faces?'); ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $show_stream; ?> id="<?php echo $this->get_field_id('show_stream'); ?>" name="<?php echo $this->get_field_name('show_stream'); ?>" /> <label for="<?php echo $this->get_field_id('show_stream'); ?>"><?php _e('Show Stream?'); ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $show_header; ?> id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" /> <label for="<?php echo $this->get_field_id('show_header'); ?>"><?php _e('Show Header?'); ?></label>
		</p>


		<label for="<?php echo $this->get_field_id( 'widget_class' ); ?>"><?php _e('Widget Background', 'largo-facebook'); ?></label>
		<select id="<?php echo $this->get_field_id('widget_class'); ?>" name="<?php echo $this->get_field_name('widget_class'); ?>" class="widefat" style="width:90%;">
		    <option <?php selected( $instance['widget_class'], 'default'); ?> value="default">Default</option>
		    <option <?php selected( $instance['widget_class'], 'rev'); ?> value="rev">Reverse</option>
		    <option <?php selected( $instance['widget_class'], 'no-bg'); ?> value="no-bg">No Background</option>
		</select>

		<p style="margin:15px 0 10px 5px">
			<input class="checkbox" type="checkbox" <?php echo $desktop; ?> id="<?php echo $this->get_field_id('hidden_desktop'); ?>" name="<?php echo $this->get_field_name('hidden_desktop'); ?>" /> <label for="<?php echo $this->get_field_id('hidden_desktop'); ?>"><?php _e('Hidden on Desktops?'); ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $tablet; ?> id="<?php echo $this->get_field_id('hidden_tablet'); ?>" name="<?php echo $this->get_field_name('hidden_tablet'); ?>" /> <label for="<?php echo $this->get_field_id('hidden_tablet'); ?>"><?php _e('Hidden on Tablets?'); ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $phone; ?> id="<?php echo $this->get_field_id('hidden_phone'); ?>" name="<?php echo $this->get_field_name('hidden_phone'); ?>" /> <label for="<?php echo $this->get_field_id('hidden_phone'); ?>"><?php _e('Hidden on Phones?'); ?></label>
		</p>
	<?php
	}
}
<?php
/*
 * List all of the terms in a custom taxonomy
 */
class largo_taxonomy_list_widget extends WP_Widget {

	function largo_taxonomy_list_widget() {
		$widget_ops = array(
			'classname' 	=> 'largo-taxonomy-list',
			'description' 	=> __('List all of the terms in a custom taxonomy with links', 'largo')
		);
		$this->WP_Widget( 'largo-taxonomy-list-widget', __('Largo Taxonomy List', 'largo'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories', 'largo' ) : $instance['title'], $instance, $this->id_base);
		$is_dropdown = ! empty( $instance['dropdown'] ) ? '1' : '0';

		/*
		 * Before the widget
		 */
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		/*
		 * The widget
		 */
		$cat_args = array(
			'orderby' 	=> 'name',
			'taxonomy' 	=> $instance['taxonomy'],
		);

		if ( $is_dropdown ) {
			$cats = get_categories($cat_args); ?>

			<select id="taxonomy-list-widget">
				<option value=""><?php printf( __('Select %s', 'largo'), ucwords($instance['taxonomy']) ); ?></option>
			<?php foreach ($cats as $cat) : ?>
				<option value="<?php echo get_term_link($cat, $cat->taxonomy) ?>"><?php echo $cat->name ?></option>
			<?php endforeach; ?>
			</select>

			<script>
				jQuery(document).ready(function() {
				    jQuery('#taxonomy-list-widget').change(function() {
				        window.location = jQuery(this).val();
				    });
				});
			</script>

		<?php } else { 
			echo '<ul>';

			// current structure of list as poutoput by the wp_list_categories,
			// <li class="cat-item cat-item-number" which is incorrect, is not cat
			// get list using get_categories,
			// then depending on whether or not we're doing the dropdown, 
			$cat_args['title_li'] = '';
			$tax_items = get_categories($cat_args);

			foreach ($tax_items as $item) {
				if ($instance['thumbnails'] == '1' && largo_is_series_enabled() ) {
					$landing_array = largo_get_series_landing_page_by_series($item);
					
					// Thumbnail shall be the one for the landing page post
					$thumbnail = '';
					foreach ($landing_array as $post) {
						$thumbnail = get_the_post_thumbnail($post->ID);
					}
					
					// add note to the widget setting saying whether or not series landing pages are enabled, and a link to where to do so. 

					// Now we do the thumbnailed list. It's safe to assume that there are no bullets on these li.
					echo sprintf(
						'<li class="%s-%s"><a href="%s">%s %s</a></li>',
						$item->taxonomy,
						$item->term_id,
						get_term_link($item),
						$thumbnail, // the image for the series
						$item->cat_name
					);
				} else { 
					echo sprintf(
						'<li class="%s-%s"><a href="%s">%s</a></li>',
						$item->taxonomy,
						$item->term_id,
						get_term_link($item),
						$item->cat_name
					);
				}
			}

			echo '</ul>';
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['taxonomy'] = strtolower(strip_tags($new_instance['taxonomy']));
		$instance['count'] = sanitize_text_field($new_instance['count']);
		if ($instance['count'] < 1) { $instance['count'] = 1; }
		$instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;
		$instance['thumbnails'] = !empty($new_instance['thumbnails']) ? 1 : 0;
		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'taxonomy' => '' ) );
		$title = esc_attr( $instance['title'] );
		$taxonomy = esc_attr( $instance['taxonomy'] );
		$count = $instance['count'];
		$dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
		$thumbnails = isset( $instance['thumbnails'] ) ? (bool) $instance['thumbnails'] : false;

		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'largo' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p>
			<label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:', 'largo'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" type="text" value="<?php echo $taxonomy; ?>" />
		</p>
		
		<p>
			<label for"<?php echo $this->get_field_id('count'); ?>"><?php _e('Count:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count')?>" type="number" value="<?php echo $count; ?>" />
		</p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
			<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown', 'largo' ); ?></label>
		</p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('thumbnails'); ?>" name="<?php echo $this->get_field_name('thumbnails'); ?>"<?php checked( $thumbnails ); ?> />
			<label for="<?php echo $this->get_field_id('thumbnails'); ?>"><?php _e( 'Display thumbnails? (only useful for series)', 'largo' ); ?></label>
		</p>

	<?php
	}

}

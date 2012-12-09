<?php
/*
 * Largo Recent Posts
 */
class largo_recent_posts_widget extends WP_Widget {

	function largo_recent_posts_widget() {
		$widget_ops = array(
			'classname' => 'largo-recent-posts',
			'description' => __('Show your most recent posts with thumbnails and excerpts', 'largo')
		);
		$this->WP_Widget( 'largo-recent-posts-widget', __('Largo Recent Posts', 'largo'), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $ids; // an array of post IDs already on a page so we can avoid duplicating posts
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );

		$widget_class = !empty($instance['widget_class']) ? $instance['widget_class'] : '';
		if ($instance['hidden_desktop'] === 1)
			$widget_class .= ' hidden-desktop';
		if ($instance['hidden_tablet'] === 1)
			$widget_class .= ' hidden-tablet';
		if ($instance['hidden_phone'] === 1)
			$widget_class .= ' hidden-phone';
		/* Add the widget class to $before widget, used as a style hook */
		if( strpos($before_widget, 'class') === false ) {
			$before_widget = str_replace('>', 'class="'. $widget_class . '"', $before_widget);
		}
		else {
			$before_widget = str_replace('class="', 'class="'. $widget_class . ' ', $before_widget);
		}

		/* Before widget*/
		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;?>

			<?php
			$query_args = array (
				'post__not_in' 	=> get_option( 'sticky_posts' ),
				'showposts' 	=> $instance['num_posts']
			);
			if ($instance['avoid_duplicates'] === 1)
				$query_args['post__not_in'] = $ids;
			if ($instance['cat'] != '')
				$query_args['cat'] = $instance['cat'];
			if ($instance['tag'] != '')
				$query_args['tag'] = $instance['tag'];
			if ($instance['author'] != '')
				$query_args['author'] = $instance['author'];
			if ($instance['taxonomy'] != '')
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => $instance['taxonomy'],
						'field' => 'slug',
						'terms' => $instance['term']
					)
				);

			$my_query = new WP_Query( $query_args );
          		if ( $my_query->have_posts() ) :
          			while ( $my_query->have_posts() ) : $my_query->the_post(); $ids[] = get_the_ID(); ?>
	                  	<div class="post-lead clearfix">
	                      	<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
	                      	<?php
	                      		$thumb = $instance['thumbnail_display'];
	                      		$excerpt = $instance['excerpt_display'];
	                      		if ($thumb == 'small')
	                      			the_post_thumbnail( '60x60' );
	                      		elseif ($thumb == 'medium')
	                      			the_post_thumbnail();
	                      		if 	($excerpt == 'num_sentences')
	                      			echo '<p>' . largo_trim_sentences(get_the_content(), $instance['num_sentences']) . '</p>';
	                      		else
	                      			the_excerpt();
	                      	?>
	                  	</div> <!-- /.post-lead -->
	            <?php endwhile;
	            else: ?>
	    		<p class="error"><strong>You don't have any recent posts.</strong></p>

    		<?php endif; // end more featured posts

    		if($instance['linkurl'] !='') {?>
				<p class="morelink"><a href="<?php echo $instance['linkurl']; ?>"><?php echo $instance['linktext']; ?></a></p>
			<?php }
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['num_posts'] = strip_tags( $new_instance['num_posts'] );
		$instance['avoid_duplicates'] = $new_instance['avoid_duplicates'] ? 1 : 0;
		$instance['thumbnail_display'] = $new_instance['thumbnail_display'];
		$instance['excerpt_display'] = $new_instance['excerpt_display'];
		$instance['num_sentences'] = strip_tags( $new_instance['num_sentences'] );
		$instance['cat'] = $new_instance['cat'];
		$instance['tag'] = $new_instance['tag'];
		$instance['taxonomy'] = $new_instance['taxonomy'];
		$instance['term'] = $new_instance['term'];
		$instance['author'] = $new_instance['author'];
		$instance['linktext'] = $new_instance['linktext'];
		$instance['linkurl'] = $new_instance['linkurl'];
		$instance['widget_class'] = $new_instance['widget_class'];
		$instance['hidden_desktop'] = $new_instance['hidden_desktop'] ? 1 : 0;
		$instance['hidden_tablet'] = $new_instance['hidden_tablet'] ? 1 : 0;
		$instance['hidden_phone'] = $new_instance['hidden_phone'] ? 1 : 0;
		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title' 			=> __('Recent Stories', 'largo'),
			'num_posts' 		=> 5,
			'avoid_duplicates'	=> '',
			'thumbnail_display' => 'small',
			'excerpt_display' 	=> 'num_sentences',
			'num_sentences' 	=> 2,
			'cat' 				=> 0,
			'tag'				=> '',
			'taxonomy'			=> '',
			'term'				=> '',
			'author' 			=> '',
			'linktext' 			=> '',
			'linkurl' 			=> '',
			'widget_class' 		=> 'default',
			'hidden_desktop' 	=> '',
			'hidden_tablet' 	=> '',
			'hidden_phone'		=> ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$duplicates = $instance['avoid_duplicates'] ? 'checked="checked"' : '';
		$desktop = $instance['hidden_desktop'] ? 'checked="checked"' : '';
		$tablet = $instance['hidden_tablet'] ? 'checked="checked"' : '';
		$phone = $instance['hidden_phone'] ? 'checked="checked"' : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'num_posts' ); ?>"><?php _e('Number of posts to show:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_posts' ); ?>" name="<?php echo $this->get_field_name( 'num_posts' ); ?>" value="<?php echo $instance['num_posts']; ?>" style="width:90%;" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php echo $duplicates; ?> id="<?php echo $this->get_field_id('avoid_duplicates'); ?>" name="<?php echo $this->get_field_name('avoid_duplicates'); ?>" /> <label for="<?php echo $this->get_field_id('avoid_duplicates'); ?>"><?php _e('Avoid Duplicate Posts?', 'largo'); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'thumbnail_display' ); ?>"><?php _e('Thumbnail Image', 'largo'); ?></label>
			<select id="<?php echo $this->get_field_id('thumbnail_display'); ?>" name="<?php echo $this->get_field_name('thumbnail_display'); ?>" class="widefat" style="width:90%;">
			    <option <?php selected( $instance['thumbnail_display'], 'small'); ?> value="small"><?php _e('Small (60x60)', 'largo'); ?></option>
			    <option <?php selected( $instance['thumbnail_display'], 'medium'); ?> value="medium"><?php _e('Medium (150x150)', 'largo'); ?></option>
			    <option <?php selected( $instance['thumbnail_display'], 'none'); ?> value="none"><?php _e('None', 'largo'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'excerpt_display' ); ?>"><?php _e('Excerpt Display', 'largo'); ?></label>
			<select id="<?php echo $this->get_field_id('excerpt_display'); ?>" name="<?php echo $this->get_field_name('excerpt_display'); ?>" class="widefat" style="width:90%;">
			    <option <?php selected( $instance['excerpt_display'], 'num_sentences'); ?> value="num_sentences"><?php _e('Use # of Sentences', 'largo'); ?></option>
			    <option <?php selected( $instance['excerpt_display'], 'custom_excerpt'); ?> value="custom_excerpt"><?php _e('Use Custom Post Excerpt', 'largo'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'num_sentences' ); ?>"><?php _e('Excerpt Length (# of Sentences):', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_sentences' ); ?>" name="<?php echo $this->get_field_name( 'num_sentences' ); ?>" value="<?php echo $instance['num_sentences']; ?>" style="width:90%;" />
		</p>

		<p><strong><?php _e('Limit by Author, Categories or Tags', 'largo'); ?></strong><br /><small><?php _e('Select an author or category from the dropdown menus or enter post tags separated by commas (\'cat,dog\')', 'largo'); ?></small></p>
		<p>
			<label for="<?php echo $this->get_field_id('author'); ?>"><?php _e('Limit to author: ', 'largo'); ?><br />
			<?php wp_dropdown_users(array('name' => $this->get_field_name('author'), 'show_option_all' => __('None (all authors)', 'largo'), 'selected'=>$instance['author'])); ?></label>

		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Limit to category: ', 'largo-recent-posts'); ?>
			<?php wp_dropdown_categories(array('name' => $this->get_field_name('cat'), 'show_option_all' => __('None (all categories)', 'largo'), 'hide_empty'=>0, 'hierarchical'=>1, 'selected'=>$instance['cat'])); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('tag'); ?>"><?php _e('Limit to tags:', 'largo'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" type="text" value="<?php echo $instance['tag']; ?>" />
		</p>

		<p><strong><?php _e('Limit by Custom Taxonomy', 'largo'); ?></strong><br /><small><?php _e('Enter the slug for the custom taxonomy you want to query and the term within that taxonomy to display', 'largo'); ?></small></p>
		<p>
			<label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:', 'largo'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" type="text" value="<?php echo $instance['taxonomy']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('term'); ?>"><?php _e('Term:', 'largo'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('term'); ?>" name="<?php echo $this->get_field_name('term'); ?>" type="text" value="<?php echo $instance['term']; ?>" />
		</p>

		<p><strong><?php _e('More Link', 'largo'); ?></strong><br /><small><?php _e('If you would like to add a more link at the bottom of the widget, add the link text and url here.', 'largo'); ?></small></p>
		<p>
			<label for="<?php echo $this->get_field_id('linktext'); ?>"><?php _e('Link text:', 'largo'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('linktext'); ?>" name="<?php echo $this->get_field_name('linktext'); ?>" type="text" value="<?php echo $instance['linktext']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('linkurl'); ?>"><?php _e('URL:', 'largo'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('linkurl'); ?>" name="<?php echo $this->get_field_name('linkurl'); ?>" type="text" value="<?php echo $instance['linkurl']; ?>" />
		</p>

		<label for="<?php echo $this->get_field_id( 'widget_class' ); ?>"><?php _e('Widget Background', 'largo'); ?></label>
		<select id="<?php echo $this->get_field_id('widget_class'); ?>" name="<?php echo $this->get_field_name('widget_class'); ?>" class="widefat" style="width:90%;">
		    <option <?php selected( $instance['widget_class'], 'default'); ?> value="default"><?php _e('Default', 'largo'); ?></option>
		    <option <?php selected( $instance['widget_class'], 'rev'); ?> value="rev"><?php _e('Reverse', 'largo'); ?></option>
		    <option <?php selected( $instance['widget_class'], 'no-bg'); ?> value="no-bg"><?php _e('No Background', 'largo'); ?></option>
		</select>

		<p style="margin:15px 0 10px 5px">
			<input class="checkbox" type="checkbox" <?php echo $desktop; ?> id="<?php echo $this->get_field_id('hidden_desktop'); ?>" name="<?php echo $this->get_field_name('hidden_desktop'); ?>" /> <label for="<?php echo $this->get_field_id('hidden_desktop'); ?>"><?php _e('Hidden on Desktops?', 'largo'); ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $tablet; ?> id="<?php echo $this->get_field_id('hidden_tablet'); ?>" name="<?php echo $this->get_field_name('hidden_tablet'); ?>" /> <label for="<?php echo $this->get_field_id('hidden_tablet'); ?>"><?php _e('Hidden on Tablets?', 'largo'); ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $phone; ?> id="<?php echo $this->get_field_id('hidden_phone'); ?>" name="<?php echo $this->get_field_name('hidden_phone'); ?>" /> <label for="<?php echo $this->get_field_id('hidden_phone'); ?>"><?php _e('Hidden on Phones?', 'largo'); ?></label>
		</p>

	<?php
	}
}
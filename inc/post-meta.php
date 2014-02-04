<?php

/**
 * Move the author dropdown to the publish metabox so it's easier to find
 *
 * @since 1.0
 */
//
if ( !is_plugin_active('co-authors-plus/co-authors-plus.php') ) {
	function move_author_to_publish_metabox() {
		global $post_ID;
		$post = get_post( $post_ID );
		echo '<div id="author" class="misc-pub-section" style="padding: 8px 10px;">Author: ';
		post_author_meta_box( $post );
		echo '</div>';
	}
	add_action( 'post_submitbox_misc_actions', 'move_author_to_publish_metabox' );
}

/**
 * Hide some of the less commonly used metaboxes to cleanup the post and page edit screens
 *
 * @since 1.0
 */
function remove_default_post_screen_metaboxes() {
	remove_meta_box( 'trackbacksdiv','post','normal' ); // trackbacks
	remove_meta_box( 'slugdiv','post','normal' ); // slug
	remove_meta_box( 'revisionsdiv','post','normal' ); // revisions
	remove_meta_box( 'authordiv', 'post', 'normal' ); // author
	remove_meta_box( 'commentsdiv','post','normal' ); // comments
}
add_action('admin_menu','remove_default_post_screen_metaboxes');

/**
 * Show all of the other metaboxes by default (particularly to show the excerpt)
 *
 * @since 1.0
 */
add_filter( 'default_hidden_meta_boxes', 'largo_change_default_hidden_metaboxes', 10, 2 );
function largo_change_default_hidden_metaboxes( $hidden, $screen ) {
    if ( 'post' == $screen->base ) {
        $hidden = array();
    }
    return $hidden;
}

/**
 * Adds custom meta boxes to the post edit screen for
 *  - custom byline and link
 *  - featured video link
 *  - custom post layout options
 *
 * @since 1.0
 */

// Register our custom meta boxes
function largo_meta_box_add() {
	$screens = array( 'post' );
	if ( of_get_option( 'custom_landing_enabled' ) ) $screens[] = 'cftl-tax-landing';
    foreach ( $screens as $screen ) {
		add_meta_box(
			'largo_byline_meta',
			__('Custom Byline Options', 'largo'),
			'largo_byline_meta_box_display',
			$screen,
			'side',
			'core'
		);
	}
	$screens = array( 'post', 'page' );
    foreach ( $screens as $screen ) {
		add_meta_box(
			'largo_layout_meta',
			__('Layout Options', 'largo'),
			'largo_layout_meta_box_display',
			$screen,
			'side',
			'core'
		);
	}
    add_meta_box(
    	'largo_featured_video',
    	__('Featured Video', 'largo'),
    	'largo_featured_video_meta_box_display',
    	'post',
    	'side',
    	'low'
    );
}
add_action( 'add_meta_boxes', 'largo_meta_box_add' );

// Save our custom meta box values as custom fields
function largo_meta_box_save( $post_id ) {
	global $post;
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'largo_meta_box_nonce' ) ) return;

	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;

	// now we can actually save the data
	$allowed = array(
		'a' => array( // on allow a tags
			'href' => array() // and those anchors can only have href attribute
		)
	);

	$mydata = array(
		'_wp_post_template' => $_POST['_wp_post_template'],
		'custom_sidebar' 	=> $_POST['custom_sidebar'],
		'largo_byline_text' => $_POST['largo_byline_text'],
		'largo_byline_link' => $_POST['largo_byline_link'],
		'youtube_url' 		=> $_POST['youtube_url']
	);

	foreach ( $mydata as $key => $value ) {
		if ( get_post_meta( $post->ID, $key, FALSE ) ) {
			update_post_meta( $post->ID, $key, $value ); //if the custom field already has a value, update it
		} else {
			add_post_meta( $post->ID, $key, $value );//if the custom field doesn't have a value, add the data
		}
		if ( !$value ) delete_post_meta( $post->ID, $key ); //and delete if blank
	}

}
add_action( 'save_post', 'largo_meta_box_save' );

// Templates for displaying the custom meta boxes
function largo_byline_meta_box_display() {
	global $post;
	$values = get_post_custom( $post->ID );
	$byline_text = isset( $values['largo_byline_text'] ) ? esc_attr( $values['largo_byline_text'][0] ) : '';
	$byline_link = isset( $values['largo_byline_link'] ) ? esc_url( $values['largo_byline_link'][0] ) : '';
	wp_nonce_field( 'largo_meta_box_nonce', 'meta_box_nonce' );
	?>
	<p>
		<label for="largo_byline_text"><?php _e('Byline Text', 'largo'); ?></label>
		<input type="text" name="largo_byline_text" id="largo_byline_text" value="<?php echo $byline_text; ?>" />
	</p>

	<p>
		<label for="largo_byline_link"><?php _e('Byline Link', 'largo'); ?></label>
		<input type="text" name="largo_byline_link" id="largo_byline_link" value="<?php echo $byline_link; ?>" />
	</p>
	<?php
}

function largo_layout_meta_box_display () {
	global $post;

	wp_nonce_field( 'largo_meta_box_nonce', 'meta_box_nonce' );

	if ( $post->post_type != 'page' ) {
		echo '<p><strong>' . __('Template', 'largo' ) . '</strong><br />';
		echo __('Select the Post Template you wish this post to use.', 'largo' ) . '</p>';
		echo '<label class="hidden" for="post_template">' . __("Post Template", 'largo' ) . '</label>';
		echo '<select name="_wp_post_template" id="post_template" class="dropdown">';
		echo '<option value="">Default</option>';
		post_templates_dropdown(); //get the options
		echo '</select>';
	}

	echo '<p><strong>' . __('Custom Sidebar', 'largo' ) . '</strong><br />';
	echo __('Select a custom sidebar to display.', 'largo' ) . '</p>';
	echo '<label class="hidden" for="custom_sidebar">' . __("Custom Sidebar", 'largo' ) . '</label>';
	echo '<select name="custom_sidebar" id="custom_sidebar" class="dropdown">';
	custom_sidebars_dropdown(); //get the options
	echo '</select>';
}

function largo_featured_video_meta_box_display() {
    global $post;
    $values = get_post_custom( $post->ID );
    $youtube_url = isset( $values['youtube_url'] ) ? esc_attr( $values['youtube_url'][0] ) : '';
    wp_nonce_field( 'largo_meta_box_nonce', 'meta_box_nonce' );

    echo __('<p>In some cases you might want to use a video in the place of the featured image. If you would prefer to use a video, enter the URL for the video (YouTube only) here:</p>', 'largo');
    echo '<input type="text" name="youtube_url" id="youtube_url" value="' . $youtube_url . '" />';
    echo __('<p class="small">Note that at the moment this is only used for the top story on the homepage but future versions of Largo might enable this functionality elsewhere in the theme.</p>', 'largo');

}
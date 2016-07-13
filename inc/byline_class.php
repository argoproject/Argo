<?php
/**
 * This file contains the Largo_Byline class, and its extensions Largo_Byline_CoAuthor and Largo_Byline_Custom
 */

/**
 * Generates a byline for a normal WordPress user
 * @todo document variables
 */
class Largo_Byline {

	function __construct( $args ) {
		$this->populate_variables( $args );
		$this->generate_byline();
	}

	function populate_variables( $args ) {
		$this->post_id = $args['post_id'];
		$this->exclude_date = $args['exclude_date'];
		$this->custom = get_post_custom( $this->post_id );
		$this->author_id = get_post_meta( $this->post_id, 'post_author', true );
	}

	function generate_byline() {
		ob_start();
		//juicy bits here
		$this->avatar();
		$this->author_link();
		$this->job_title();
		$this->twitter();
		$this->published_date();
		$this->edited_date();
		$this->edit_link();

		$this->output = ob_get_clean();
	}

	public function __toString() {
		return $this->output;
	}

	function avatar() {
		$output = get_avatar(
			$author_id,
			32, // image size shall be 32px square; this usually gets visually shrunk with CSS
			'', // default url for image shall be emptystring to prevent loading image if author has none
			sprintf( __('Avatar for %1$s', 'largo'), $author_name ), // alt for the image
			array( // the other args, see https://codex.wordpress.org/Function_Reference/get_avatar
				'class' => '', // empty for now, we may want to add classes to this image
				'force_display' => false, // this is default value; to toggle display of avatars check "Show Avatars" in Settings > Discussion
			)
		);
		$output .= ' '; // to reduce run-together bylines
		echo $output;
	}

	function author_link() {
		// a wrapper around the appropriate function
		$authors = largo_author_link( false, $this->post_id );
		$output = '<span class="by-author"><span class="by">' . __( 'By', 'largo' ) . '</span> <span class="author vcard" itemprop="author">' . $authors . '</span></span>';
		echo $output;
	}

	function job_title() {
		$show_job_titles = of_get_option('show_job_titles');
		// only do this if we're showing job titles and there is one to be shown
		if ( $show_job_titles && $job = get_the_author_meta( 'job_title' , $this->author_id ) ) {
			$output .= '<span class="job-title"><span class="comma">,</span> ' . $job . '</span>';
		}
		$output .= '';
		echo $output;
	}

	function twitter() {
		$twitter = get_the_author_meta('twitter', $this->author_id);
		if ( $twitter && is_single() ) {
			$output .= ' <span class="twitter"><a href="https://twitter.com/' . largo_twitter_url_to_username( $twitter ) . '"><i class="icon-twitter"></i></a></span>';
		}
		echo $output;
	}

	// A wrapper around largo_time to determine when the post was published
	function published_date() {
		$output = '';
		if ( ! $this->exclude_date ) {
			printf(
				' <time class="entry-date updated dtstamp pubdate" datetime="%1$s"><span class="published">%2$s </span>%3$s</time>',
				esc_attr( get_the_date( 'c', $this->post_id ) ),
				__( 'Published', 'largo' ),
				largo_time( false, $this->post_id )
			);
		}
		echo $output;
	}

	// @todo: should this be displayed under different conditions?
	function edited_date() {
		if (
			current_user_can( 'edit_post', $this->post_id )
			&& ! $this->exclude_date
		) {
			printf(
				' <span class="last-modified">%1$s %2$s %3$s %4$s</span',
				__( 'Last modified', 'largo' ),
				get_the_modified_date( 'F j, Y' ),
				__( 'at', 'largo' ),
				get_the_modified_date( 'g:i a' )
			);
		}
	}

	// @todo: why is this not working for my user on vagrant?
	function edit_link() {
		// Add the edit link if the current user can edit the post
		$output = '';
		if ( current_user_can( 'edit_post', $this->post_id ) ) {
			$output = '<span class="edit-link"><a href="' . get_edit_post_link( $this->post_id ) . '">' . __( 'Edit This Post', 'largo' ) . '</a></span>';
		}
		echo $ouptut;
	}
}

// For Largo Custom Bylines
class Largo_Custom_Byline extends Largo_Byline {

	/**
	 * differs from Largo_Byline in following ways:
	 * - no avatar
	 * - no job title
	 * - no twitter
	 */
	function generate_byline() {
		ob_start();
		$this->author_link();
		$this->published_date();
		$this->edited_date();
		$this->edit_link();

		$this->output = ob_get_clean();
	}
}

class Largo_CoAuthors_Byline extends Largo_Byline {
}

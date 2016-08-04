<?php
/**
 * This file contains the Largo_Byline class, and its extensions Largo_Byline_CoAuthor and Largo_Byline_Custom
 */

/**
 * Generates a byline for a normal WordPress user
 * @param Array $args an array with the following keys:
 *     - int post_id the ID of the post that we are creating a byline for
 *     - bool exclude_date Whether or not to display the date
 */
class Largo_Byline {

	/** @var int The ID of the post this byline is for */
	private $post_id;

	/** @var bool Whether or not the byline should include the date */
	private $exclude_date;

	/**
	 * @var array The post's custom fields
	 * @link https://codex.wordpress.org/Function_Reference/get_post_custom
	 */
	private $custom;

	/** @var int The ID of the author for this post */
	private $author_id;

	/**
	 * @var string The HTML ouput of this class
	 * @see __toString
	 */
	public $output;

	function __construct( $args ) {
		$this->populate_variables( $args );
		$this->generate_byline();
	}

	/**
	 * Set us up the vars
	 *
	 * @param array $args Associative array containing following keys:
	 *     - 'post_id': an integer post ID
	 *     - 'exclude_date': boolean whether or not to include the date in the byline
	 *
	 * @see $post_id      Sets this from $args
	 * @see $exclude_date Sets this from $args
	 * @see $custom       Fills this array with the output of get_post_custom
	 * @see $author_id    Sets this from the post meta
	 */
	function populate_variables( $args ) {
		$this->post_id = $args['post_id'];
		$this->exclude_date = $args['exclude_date'];
		$this->custom = get_post_custom( $this->post_id );
		$this->author_id = get_post_meta( $this->post_id, 'post_author', true );
	}

	/**
	 * this creates the byline text and adds it to $this->output
	 *
	 * @see $output Creates this
	 */
	function generate_byline() {
		ob_start();

		// Author-specific portion of byline
		$this->avatar();
		$this->author_link();
		$this->job_title();
		$this->twitter();

		// The generic parts
		$this->maybe_updated_date();
		$this->edit_link();

		$this->output = ob_get_clean();
	}

	/**
	 * This is what turns the whole class into a string
	 *
	 * @see $output
	 * @see generate_byline()
	 */
	public function __toString() {
		return $this->output;
	}

	/**
	 * On single posts, output the avatar for the author object
	 */
	function avatar() {
		$author_email = get_the_author_meta( 'email', $this->author_id );

		// only do avatars if it's a single post
		if ( is_single() ) {
			if ( largo_has_avatar( $author_email ) ) {
				$output .= get_avatar(
					$author_email,
					32,
					'',
					get_the_author_meta( 'display_name', $this->author_id )
				);
			} elseif ( $this->author->type == 'guest-author' && get_the_post_thumbnail( $this->author->ID ) ) {
				$output = get_the_post_thumbnail( $this->author_id, array( 32,32 ) );
				$output = str_replace( 'attachment-32x32 wp-post-image', 'avatar avatar-32 photo', $output );
			}
		}

		$output .= ' '; // to reduce run-together bylines
		echo $output;
	}

	/**
	 * a wrapper around largo_author_link
	 */
	function author_link() {
		$authors = largo_author_link( false, $this->post_id );
		$output = '<span class="by-author"><span class="by">' . __( 'By', 'largo' ) . '</span> <span class="author vcard" itemprop="author">' . $authors . '</span></span>';
		echo $output;
	}

	/**
	 * If job titles are enabled by Largo's theme option, display the one for this author
	 */
	function job_title() {
		$show_job_titles = of_get_option( 'show_job_titles', false );
		// only do this if we're showing job titles and there is one to be shown
		if ( $show_job_titles && $job = get_the_author_meta( 'job_title' , $this->author_id ) ) {
			$output .= '<span class="job-title"><span class="comma">,</span> ' . $job . '</span>';
		}
		$output .= '';
		echo $output;
	}

	/**
	 * If this author has a twitter ID, output it as a link on an i.icon-twitter
	 */
	function twitter() {
		$twitter = get_the_author_meta( 'twitter', $this->author_id );
		if ( $twitter && is_single() ) {
			$output .= ' <span class="twitter"><a href="https://twitter.com/' . largo_twitter_url_to_username( $twitter ) . '"><i class="icon-twitter"></i></a></span>';
		}
		echo $output;
	}

	/**
	 * Determine which date to display
	 */
	function maybe_updated_date() {
		if ( ! $this->exclude_date ) {
			if ( is_single() && largo_post_was_updated( $this->post ) ) {
				$this->edited_date();
			} else {
				$this->published_date();
			}
		}
	}

	/**
	 * A wrapper around largo_time to determine when the post was published
	 */
	function published_date() {
		echo sprintf(
			' <time class="entry-date updated dtstamp pubdate" datetime="%1$s"><span class="published">%2$s </span>%3$s</time>',
			esc_attr( get_the_date( 'c', $this->post_id ) ),
			__( 'Published', 'largo' ),
			largo_time( false, $this->post_id )
		);
	}

	/**
	 * Display the last-edited date for this post, only to admin users
	 *
	 * @todo: should this be displayed under different conditions?
	 */
	function edited_date() {
		echo sprintf(
			' <time class="entry-date updated dtstamp" datetime="%1$s"><span class="last-modified">%2$s %3$s %4$s %5$s</span></time> ',
			esc_attr( get_the_modified_date( 'c', $this->post_id ) ),
			__( 'Updated', 'largo' ),
			largo_modified_time( false, $this->post_id ),
			__( 'at', 'largo' ),
			get_the_modified_date( 'g:i a' )
		);
	}

	/**
	 * Output the edit link for this post, only to admin users
	 */
	function edit_link() {
		// Add the edit link if the current user can edit the post
		if ( current_user_can( 'edit_published_posts' ) ) {
			echo ' <span class="edit-link"><a href="' . get_edit_post_link( $this->post_id ) . '">' . __( 'Edit This Post', 'largo' ) . '</a></span>';
		}
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
		$this->maybe_updated_date();
		$this->edit_link();

		$this->output = ob_get_clean();
	}
}

/**
 * Bylines for Co-Authors Plus guest authors
 */
class Largo_CoAuthors_Byline extends Largo_Byline {

	/**
	 * Temporary variable used to contain the coauthor being rendered by the loop inside generate_byline();
	 * @see $this->generate_byline();
	 */
	protected $author;

	/**
	 * Differs from Largo_Byline in following ways:
	 *
	 * - gets list of coauthors, runs avatar, author_link, job_title, organization, twitter for each of those
	 * - joins list of coauthors with commas and 'and' as appropriate
	 *
	 */
	function generate_byline() {
		// get the coauthors for this post
		$coauthors = get_coauthors( $this->post_id );
		$out = array();
		// loop over them
		foreach( $coauthors as $author ) {
			$this->author_id = $author->ID;
			$this->author = $author;

			ob_start();

			$this->avatar();
			$this->author_link();
			$this->job_title();
			$this->organization();
			$this->twitter();

			$byline_temp = ob_get_clean();

			// array of byline html strings
			$out[] = $byline_temp;
		}

		// If there are multiple coauthors, join them with commas and 'and'
		if ( count( $out ) > 1 ) {
			end( $out );
			$key = key( $out );
			reset( $out );
			$authors = implode( ', ', array_slice( $out, 0, -1 ) );
			$authors .= ' <span class="and">' . __( 'and', 'largo' ) . '</span> ' . $out[$key];
		} else {
			$authors = $out[0];
		}


		// Now assemble the One True Byline
		ob_start();
		echo $authors;
		$this->maybe_updated_date();
		$this->edit_link();

		$this->output = ob_get_clean();
	}

	/**
	 * A coauthors-specific byline link method
	 */
	function author_link() {
		$author_name = ( ! empty($this->author->display_name) ) ? $this->author->display_name : $this->author->user_nicename ;

		$output = '<a class="url fn n" href="' . get_author_posts_url( $this->author->ID, $this->author->user_nicename ) . '" title="' . esc_attr( sprintf( __( 'Read All Posts By %s', 'largo' ), $author_name ) ) . '" rel="author">' . esc_html( $author_name ) . '</a>';
		echo $output;
	}

	/**
	 * Job title from the coauthors object
	 */
	function job_title() {
		$show_job_titles = of_get_option( 'show_job_titles', false );
		// only do this if we're showing job titles and there is one to be shown
		if ( true && $job = $this->author->job_title ) {
			$output .= '<span class="job-title"><span class="comma">,</span> ' . $job . '</span>';
		}
		$output .= '';
		echo $output;
	}

	/**
	 * Output coauthor users's organization
	 */
	function organization() {
		if ( $org = $this->author->organization ) {
			$byline_text = ' (' . $org . ')';
			echo $byline_text;
		}
	}

	/**
	 * twitter link from the coauthors object
	 */
	function twitter() {
		if ( isset( $this->author->twitter ) && is_single() ) {
			$output .= ' <span class="twitter"><a href="https://twitter.com/' . largo_twitter_url_to_username( $this->author->twitter ) . '"><i class="icon-twitter"></i></a></span>';
		}
		echo $output;
	}
}

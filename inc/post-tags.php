<?php

/**
 * For posts published less than 24 hours ago, show "time ago" instead of date, otherwise just use get_the_date
 *
 * @param $echo bool echo the string or return itv (default: echo)
 * @return string date and time as formatted html
 * @since 0.3
 */
if ( ! function_exists( 'largo_time' ) ) {
	function largo_time($echo=true, $post=null) {
		if (!empty($post)) {
			if (is_object($post))
				$post_id = $post->ID;
			else if (is_numeric($post))
				$post_id = $post;
		} else
			$post_id = get_the_ID();

		$time_difference = current_time('timestamp') - get_the_time('U', $post_id);

		if ( $time_difference < 86400 )
			$output = sprintf( __('<span class="time-ago">%s ago</span>', 'largo' ),
				human_time_diff( get_the_time('U', $post_id), current_time( 'timestamp' ) )
			);
		else
			$output = get_the_date(null, $post_id);

		if ( $echo )
			echo $output;
		return $output;
	}
}

/**
 * Get the author name when custom byline options are set
 *
 * @param $echo bool echo the string or return it (default: echo)
 * @return string author name as formatted html
 * @since 0.3
 */
if ( ! function_exists( 'largo_author' ) ) {
	function largo_author( $echo = true ) {
		global $post;
		$values = get_post_custom( $post->ID );
		$byline_text = isset( $values['largo_byline_text'] ) ? $values['largo_byline_text'][0] : get_the_author();

		if ( $echo )
			echo $byline_text;
		return $byline_text;
	}
}

/**
 * Get the author link when custom byline options are set
 *
 * @param $echo bool echo the string or return it (default: echo)
 * @return string author link as formatted html
 * @since 0.3
 */
if ( ! function_exists( 'largo_author_link' ) ) {
	function largo_author_link( $echo = true, $post=null ) {
		$post = get_post( $post );
		$values = get_post_custom( $post->ID );
		$author_id = ( $post ) ? $post->post_author : get_the_author_meta( 'ID' );

		$byline_text = isset( $values['largo_byline_text'] ) ? $values['largo_byline_text'][0] : get_the_author_meta('display_name', $author_id);

		// if it's a custom byline but there's no link, just output the byline text
		if ( isset( $values['largo_byline_text'] ) && !isset( $values['largo_byline_link'] ) ) {
			$output = esc_html( $byline_text );
		} else {
			$byline_link = isset( $values['largo_byline_link'] ) ? $values['largo_byline_link'][0] : get_author_posts_url( get_the_author_meta( 'ID', $author_id ) );
			$byline_title_attr = sprintf( __( 'More from %s','largo' ), $byline_text );
			$output = '<a class="url fn n" href="' . esc_url( $byline_link ) . '" title="' . esc_attr( $byline_title_attr ) . '" rel="author">' . esc_html( $byline_text ) . '</a>';
		}

		if ( $echo )
			echo $output;
		return $output;
	}
}

/**
 * Outputs custom byline and link (if set), otherwise outputs author link and post date
 *
 * @param Boolean $echo Echo the string or return it (default: echo)
 * @param Boolean $exclude_date Whether to exclude the date from byline (default: false)
 * @param WP_Post|Integer $post The post object or ID to get the byline for. Defaults to current post.
 * @return String Byline as formatted html
 * @since 0.3
 */
if ( ! function_exists( 'largo_byline' ) ) {
	function largo_byline( $echo = true, $exclude_date = false, $post = null ) {

		// Get the post ID
		if (!empty($post)) {
			if (is_object($post))
				$post_id = $post->ID;
			else if (is_numeric($post))
				$post_id = $post;
		} else {
			$post_id = get_the_ID();
		}

		// Set us up the options
		// This is an array of things to allow us to easily add options in the future
		$options = array(
			'post_id' => $post_id,
			'values' => get_post_custom( $post_id ),
			'exclude_date' => $exclude_date,
		);

		/**
		 * The byline action
		 *
		 * @param array $options todo needs docs
		 *
		 * functions hooked on this should echo and return their output; all output from these functions is captured in PHP's output buffering using ob_start
		 * functions hooked on this should not use output buffering. If you do use output buffering, make sure you close all buffers you open.
		 *
		 * Default order of operations:
		 *       10 largo_byline_component_authors
		 *       20 largo_byline_component_sep
		 *       30 largo_byline_component_date
		 *     1000 largo_byline_component_edit_link
		 *
		 * @todo: give this better docs
		 */
		ob_start();
		do_action('largo_byline', $options);
		$output = ob_get_clean();

		/**
		 * Filter the largo_byline output text to allow adding items at the beginning or the end of the text.
		 *
		 * @since 0.5.4
		 * @param string $partial The HTML of the output of largo_byline(), before the edit link is added.
		 * @link https://github.com/INN/Largo/issues/1070
		 */
		$output = apply_filters( 'largo_byline', $output );

		if ( $echo ) {
			echo $output;
		} else {
			return $output;
		}
	}
}

/**
 * Largo byline component: output the author list
 * @uses largo_byline_coauthors
 * @uses largo_byline_normal_or_custom
 *
 * @since Largo 0.5.5
 * @link https://github.com/INN/Largo/issues/1126
 */
function largo_byline_component_authors($options) {
	extract($options);

	// get the post's custom meta

	if ( function_exists( 'get_coauthors' ) && !isset( $values['largo_byline_text'] ) ) {
		// If Co-Authors Plus is enabled and there is not a custom byline
		$authors = largo_byline_coauthors( $post_id );
	} else {
		// If Co-Authors Plus is not enabled or if there is a custom byline
		$authors = largo_byline_normal_or_custom( $post_id );
	}
	// Generate the HTML for the author portion of the byline
	$output = '<span class="by-author"><span class="by">' . __( 'By', 'largo' ) . '</span> <span class="author vcard" itemprop="author">' . $authors . '</span></span>';

	echo $output;
	return $output;
}
add_action('largo_byline', 'largo_byline_component_authors', 10); // we will assume that this is first

add_action('largo_byline', 'largo_byline_component_sep', 20);

/**
 * #todo: doc this
 */
function largo_byline_component_publish_datetime($options) {
	extract($options);

	// Add the date if it is not excluded
	if ( ! $exclude_date ) {
		$output .= '<span class="sep"> | </span><time class="entry-date updated dtstamp pubdate" datetime="' . esc_attr( get_the_date( 'c', $post_id ) ) . '">' . largo_time(false, $post_id) . '</time>';
	}

	echo $output;
	return $output;
}
add_action('largo_byline', 'largo_byline_component_sep', 30);

/**
 * @todo: doc this
 */
function largo_byline_component_edit_link($options) {
	extract($options);

	// Add the edit link if the current user can edit the post
	if ( current_user_can( 'edit_post', $post_id ) ) {
		$output .= '<span class="edit-link"><a href="' . get_edit_post_link( $post_id ) . '">' . __( 'Edit This Post', 'largo' ) . '</a></span>';
	}

	echo $ouptut;
	return $output;
}
add_action('largo_byline', 'largo_byline_component_edit_link', 1000); // this should always be the last

/**
 * @todo: doc this
 */
function largo_byline_component_sep($options) {
	$output = '<span class="sep"> | </span>';
	echo $output;
	return $output;
}

/**
 * function to output the coauthors for a post
 *
 * If this function is called and Co-Authors Plus is not active (as determined by the presence of `get_coauthors()`), then it will fallback to `largo_byline_regular_user()`
 *
 * @uses get_coauthors
 * @param Integer $post_id The ID of the post
 * @return String HTML of the author links
 * @since 0.5.5
 */
if ( ! function_exists( 'largo_byline_coauthors' ) ) {
	function largo_byline_coauthors( $post_id ) {
		if ( ! function_exists( 'get_coauthors' ) ) {
			return largo_byline_normal_or_custom( $post_id );
		}

		$coauthors = get_coauthors( $post_id );
		foreach( $coauthors as $author ) {
			$byline_text = $author->display_name;
			$show_job_titles = of_get_option('show_job_titles');
			if ( $org = $author->organization )
				$byline_text .= ' (' . $org . ')';

			$byline_temp = '<a class="url fn n" href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '" title="' . esc_attr( sprintf( __( 'Read All Posts By %s', 'largo' ), $author->display_name ) ) . '" rel="author">' . esc_html( $byline_text ) . '</a>';
			if ( $show_job_titles && $job = $author->job_title ) {
				// Use parentheses in case of multiple guest authorss. Comma separators would be nonsensical: Firstname lastname, Job Title, Secondname Thirdname, and Fourthname Middle Fifthname
				$byline_temp .= ' <span class="job-title"><span class="paren-open">(</span>' . $job . '<span class="paren-close">)</span></span>';
			}

			$out[] = $byline_temp;
		}

		// If there are multiple coauthors, join them with commas and 'and'
		if ( count($out) > 1 ) {
			end($out);
			$key = key($out);
			reset($out);
			$authors = implode( ', ', array_slice( $out, 0, -1 ) );
			$authors .= ' <span class="and">' . __( 'and', 'largo' ) . '</span> ' . $out[$key];
		} else {
			$authors = $out[0];
		}

		return $authors;
	}
}

/**
 * Return largo_author_link for the post, and if applicable the post author's job title
 *
 * @param Integer $post_id The id of the post
 * @return String HTML for the author, possibly including the author's link and job description
 * @since 0.5.5
 */
if ( ! function_exists( 'largo_byline_normal_or_custom' ) ) {
	function largo_byline_normal_or_custom( $post_id ) {
		$values = get_post_custom( $post_id );

		$authors = largo_author_link( false, $post_id );

		// add the author's job title
		$author_id = get_post_meta( $post_id, 'post_author', true );
		$show_job_titles = of_get_option('show_job_titles');
		if ( !isset( $values['largo_byline_text'] ) && $show_job_titles && $job = get_the_author_meta( 'job_title' , $author_id ) ) {
			$authors  .= '<span class="job-title"><span class="comma">,</span> ' . $job . '</span>';
		}

		return $authors;
	}
}

/**
 * Make a nicer-looking excerpt regardless of how an author has been using excerpts in the past
 *
 * @param $post object the post
 * @param $sentence_count int the number of sentences to show
 * @param $use_more bool append read more link to end of output
 * @param $more_link string the text of the read more link
 * @param $echo bool echo the output or return it (default: echo)
 * @param $strip_tags|$strip_shortcodes bool
 * @uses largo_trim_sentences
 * @package largo
 * @since 0.3
 */
if ( ! function_exists( 'largo_excerpt' ) ) {
	function largo_excerpt( $the_post=null, $sentence_count = 5, $use_more = false, $more_link = '', $echo = true, $strip_tags = true, $strip_shortcodes = true ) {
		if (!empty($use_more))
			_deprecated_argument(__FUNCTION__, '0.5.1', 'Parameter $use_more is deprecated.');
		if (!empty($more_link))
			_deprecated_argument(__FUNCTION__, '0.5.1', 'Parameter $more_link is deprecated.');

		$the_post = get_post($the_post); // Normalize it into a post object

		if (!empty($the_post->post_excerpt)) {
			// if a post has a custom excerpt set, we'll use that
			$content = apply_filters('get_the_excerpt', $the_post->post_excerpt);
		} else if (is_home() && preg_match('/<!--more(.*?)?-->/', $the_post->post_content, $matches) > 0) {
			// if we're on the homepage and the post has a more tag, use that
			$parts = explode($matches[0], $the_post->post_content, 2);
			$content = $parts[0];
		} else {
			// otherwise we'll just do our best and make the prettiest excerpt we can muster
			$content = largo_trim_sentences($the_post->post_content, $sentence_count);
		}

		// optionally strip shortcodes and html
		$output = '';
		if ( $strip_tags && $strip_shortcodes )
			$output .= strip_tags( strip_shortcodes ( $content ) );
		else if ( $strip_tags )
			$output .= strip_tags( $content );
		else if ( $strip_shortcodes )
			$output .= strip_shortcodes( $content );
		else
			$output .= $content;

		$output = apply_filters('the_content', $output);

		if ( $echo )
			echo $output;

		return $output;
	}
}

/**
 * Attempt to trim input at sentence breaks
 *
 * @param $input string
 * @param $sentences number of sentences to trim to
 * @param $echo echo the string or return it (default: return)
 * @return $output trimmed string
 *
 * @since 0.3
 */
function largo_trim_sentences( $input, $sentences, $echo = false ) {
	$re = '/# Split sentences on whitespace between them.
		(?<=                # Begin positive lookbehind.
			[.!?]           	# Either an end of sentence punct,
			| [.!?][\'"]    	# or end of sentence punct and quote.
		)                   # End positive lookbehind.
		(?<!                # Begin negative lookbehind.
			Mr\.            	# Skip either "Mr."
		    | Mrs\.             # or "Mrs.",
		    | Ms\.              # or "Ms.",
		    | Jr\.              # or "Jr.",
		    | Dr\.              # or "Dr.",
		    | Prof\.            # or "Prof.",
		    | Sr\.              # or "Sr.",
		    | Rep\.             # or "Rep.",
		    | Sen\.             # or "Sen.",
		    | Gov\.             # or "Gov.",
		    | Pres\.            # or "Pres.",
		    | U\.S\.            # or "U.S.",
		    | Rev\.            	# or "Rev.",
		    | Gen\.        		# or "Gen.",
		    | Capt\.            # or "Capt.",
		    | Lt\.            	# or "Lt.",
		    | Cpl\.            	# or "Cpl.",
		    | Inc\.            	# or "Inc.",
		    | \s[A-Z]\.         # or initials ex: "George W. Bush",
		    | [A-Z]\.[A-Z]\.    # or random state abbreviations ex: "O.H.",
		)                   # End negative lookbehind.
		\s+                 # Split on whitespace between sentences.
		/ix';

	$strings = preg_split( $re, strip_tags( strip_shortcodes( $input ) ), -1, PREG_SPLIT_NO_EMPTY);

	$output = '';

	for ( $i = 0; $i < $sentences && $i < count($strings); $i++ ) {
		if ( $strings[$i] != '' )
			$output .= $strings[$i] . ' ';
	}

	if ( $echo )
		echo $output;

	return $output;
}

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 * @since 0.3
 */
if ( ! function_exists( 'largo_comment' ) ) {
	function largo_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback', 'largo' ); ?>: <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'largo' ), '<span class="edit-link">', '</span>' ); ?></p>
		<?php
				break;
			default :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php
							$avatar_size = 68;
							if ( '0' != $comment->comment_parent )
								$avatar_size = 39;

							echo get_avatar( $comment, $avatar_size );

							/* translators: 1: comment author, 2: date and time */
							printf( '%1$s on %2$s <span class="says">said:</span>',
								sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
								sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									/* translators: 1: date, 2: time */
									sprintf( '%1$s at %2$s', get_comment_date(), get_comment_time() )
								)
							);
						?>

						<?php edit_comment_link( __( 'Edit', 'largo' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-author .vcard -->

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'largo' ); ?></em>
						<br />
					<?php endif; ?>

				</footer>

				<div class="comment-content"><?php comment_text(); ?></div>

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => sprintf( '%s <span>&darr;</span>', __( 'Reply', 'largo' ) ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</article><!-- #comment-## -->

		<?php
				break;
		endswitch;
	}
}

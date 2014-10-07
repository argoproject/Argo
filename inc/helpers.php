<?php
/**
 * Returns a Twitter username (without the @ symbol)
 *
 * @param 	string 	$url a twitter url
 * @return 	string	the twitter username extracted from the input string
 * @since 0.3
 */
function largo_twitter_url_to_username( $url ) {
	$urlParts = explode("/", $url);
	$username = $urlParts[3];
	return $username;
}

/**
 * Give it a YouTube URL, it'll give you just the video ID
 *
 * @param 	string 	$url a YouTube URL (e.g. - https://www.youtube.com/watch?v=i5vfw5f1CZo)
 * @return 	string	just the video ID (e.g. - i5vfw5f1CZo)
 * @since 0.4
 */
function largo_youtube_url_to_ID( $url ) {
	parse_str( parse_url( $url, PHP_URL_QUERY ), $var_array );
	$youtubeID = $var_array['v'];
	return $youtubeID;
}

/**
 * For a given YouTube URL, return an iframe to embed
 *
 * @param 	string 	$url a YouTube URL (e.g. - https://www.youtube.com/watch?v=i5vfw5f1CZo)
 * @param 	bool 	$echo return or echo the output
 * @return 	string	a standard YouTube iframe embed code
 * @uses 	largo_youtube_url_to_ID
 * @since 0.4
 */
function largo_youtube_iframe_from_url( $url, $echo = TRUE ) {
	$output = '<iframe  src="//www.youtube.com/embed/' . largo_youtube_url_to_ID( $url ) . '" frameborder="0" allowfullscreen></iframe>';
	if ( $echo ) {
		echo $output;
	} else {
		return $output;
	}
}

/**
 * For a given YouTube URL, return the image url for various thumbnail sizes
 *
 * @param 	string 	$url a YouTube URL (e.g. - https://www.youtube.com/watch?v=i5vfw5f1CZo)
 * @param	string the image size you'd like (options are: thumb | small | medium | large)
 * @param 	bool 	$echo return or echo the output
 * @return 	string	a youtube image url
 * @uses 	largo_youtube_url_to_ID
 * @since 0.4
 */

function largo_youtube_image_from_url( $url, $size = large, $echo = TRUE ) {
	$id = largo_youtube_url_to_ID( $url );

	$output = 'http://img.youtube.com/vi/' . $id;
	switch( $size ) {
		case 'thumb':
			$output .= '/default.jpg'; // 120 x 90
			break;
		case 'small':
			$output .= '/hqdefault.jpg'; // 480 x 360
			break;
		case 'medium':
			$output .= '/sddefault.jpg'; // 640 x 480
			break;
		case 'large':
			$output .= '/maxresdefault.jpg'; // 1280 x 720
			break;
	}

	if ( $echo ) {
		echo $output;
	} else {
		return $output;
	}
}
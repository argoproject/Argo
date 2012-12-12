<?php

if ( ! function_exists( 'largo_header' ) ) {
/**
 * output the site header
 */
	function largo_header() {
			$header_tag = is_home() ? 'h1' : 'h2';
			$header_class = of_get_option( 'no_header_image' ) ? 'branding' : 'visuallyhidden';
			$divider = $header_class == 'branding' ? '' : ' - ';
    		//print the text-only version of the site title
    		printf('<%1$s class="%2$s"><a href="%3$s">%4$s%5$s<span class="tagline">%6$s</span></a></%1$s>',
	    		$header_tag,
	    		$header_class,
	    		esc_url( home_url( '/' ) ),
	    		esc_attr( get_bloginfo('name') ),
	    		$divider,
	    		esc_attr( get_bloginfo('description') )
	    	);
	    	if ($header_class != 'branding')
	    		echo '<a href="' . esc_url( home_url( '/' ) ) . '"><img class="header_img" src="" alt="" /></a>';
		}
} // ends check for largo_header()

if ( ! function_exists( 'largo_copyright_message' ) ) {
/**
 * print the copyright message in the footer
 */
	function largo_copyright_message() {
	    $msg = of_get_option( 'copyright_msg' );
	    if ( ! $msg )
	    	$msg = __( 'Copyright %s', 'largo' );
	    printf( $msg, date( 'Y' ) );
	}
} // ends check for largo_copyright_message()

if ( ! function_exists( 'largo_social_links' ) ) {
/**
 * outputs all of the social media links from the theme options
 */
	function largo_social_links () {

		$fields = array(
			'rss' 		=> __( 'Link to RSS Feed', 'largo' ),
			'facebook' 	=> __( 'Link to Facebook Profile', 'largo' ),
			'twitter' 	=> __( 'Link to Twitter Page', 'largo' ),
			'youtube' 	=> __( 'Link to YouTube Page', 'largo' ),
			'flickr' 	=> __( 'Link to Flickr Page', 'largo' ),
			'gplus' 	=> __( 'Link to Google Plus Page', 'largo' )
		);

		foreach ( $fields as $field => $title ) {
			$field_link =  $field . '_link';

			if ( of_get_option( $field_link ) ) {
				echo '<li><a href="' . esc_url( of_get_option( $field_link ) ) . '" title="' . $title . '"><i class="social-icons ' . $field . '"></i></a></li>';
			}
		}
	}
} // ends check for largo_social_links()
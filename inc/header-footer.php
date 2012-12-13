<?php

if ( ! function_exists( 'largo_header' ) ) {
/**
 * output the site header
 */
	function largo_header() {
			$header_tag = is_home() ? 'h1' : 'h2'; // use h1 for the homepage, h2 for internal pages

			// if we're using the text only header, display the output, otherwise this is just replacement text for the banner image
			$header_class = of_get_option( 'no_header_image' ) ? 'branding' : 'visuallyhidden';
			$divider = $header_class == 'branding' ? '' : ' - ';

    		// print the text-only version of the site title
    		printf('<%1$s class="%2$s"><a href="%3$s">%4$s%5$s<span class="tagline">%6$s</span></a></%1$s>',
	    		$header_tag,
	    		$header_class,
	    		esc_url( home_url( '/' ) ),
	    		esc_attr( get_bloginfo('name') ),
	    		$divider,
	    		esc_attr( get_bloginfo('description') )
	    	);

	    	// add an image placeholder, the src is added by largo_header_js() in inc/enqueue.php
	    	if ($header_class != 'branding')
	    		echo '<a href="' . esc_url( home_url( '/' ) ) . '"><img class="header_img" src="" alt="" /></a>';
		}
}

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
}

if ( ! function_exists( 'largo_social_links' ) ) {
/**
 * Outputs a list of social media links (with icons) from theme options
 */
	function largo_social_links() {

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
}

if ( ! function_exists( 'largo_shortcut_icons' ) ) {
/**
 * Adds shortcut icons to the header
 */
	function largo_shortcut_icons() {
		if ( of_get_option( 'logo_thumbnail_sq' ) ) ?>
			<link rel="apple-touch-icon" href="<?php echo of_get_option( 'logo_thumbnail_sq' ); ?>"/>
		<?php if ( of_get_option( 'favicon' ) ) ?>
			<link rel="shortcut icon" href="<?php echo of_get_option( 'favicon' ); ?>" />
	<?php
	}
}
add_action( 'wp_head', 'largo_shortcut_icons' );
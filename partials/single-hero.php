<?php
$hero_class = largo_hero_class( $post->ID, FALSE );
$values = get_post_custom( $post->ID );

// If the box is checked to override the featured image display we'll treat the hero as if it was empty
// EXCEPT if a featured video is specified
if ( isset($values['featured-image-display'][0] ) && !isset( $values['youtube_url'] ) ) $hero_class = 'is-empty';

if ( $hero_class != 'is-empty') {
	echo '<div class="hero span12 ' . $hero_class . '">';
		if ( $youtube_url = $values['youtube_url'] ) {
			echo '<div class="embed-container">';
			largo_youtube_iframe_from_url( $youtube_url );
			echo '</div>';
		} elseif ( has_post_thumbnail() ) {
			largo_hero_with_caption( $post->ID );
		}
	echo '</div>';
}
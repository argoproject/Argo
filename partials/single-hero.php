<?php
$hero_class = largo_hero_class( $post->ID, FALSE );

if ( $hero_class != 'is-empty' ) {
	$values = get_post_custom( $post->ID );
	echo '<div class="hero span12 ' . $hero_class . '">';
		if ( $youtube_url = $values['youtube_url'] ) {
			echo '<div class="embed-container">';
			largo_youtube_iframe_from_url( $youtube_url );
			echo '</div>';
		} elseif ( has_post_thumbnail() && !isset( $values['featured-image-display'] ) ) {
			largo_hero_with_caption( $post->ID );
		}
	echo '</div>';
}
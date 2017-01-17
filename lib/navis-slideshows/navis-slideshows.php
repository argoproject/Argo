<?php
/**
 * Plugin Name: Navis Slideshows
 * Description: Slideshows that take advantage of the Slides jQuery plugin.
 * Version: 0.3
 * Author: Project Argo, Crowd Favorite, Cornershop Creative
 * License: GPLv2
*/
/*
	Copyright 2011 National Public Radio, Inc.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Navis_Slideshows {

	public $slideshows = 0;

	function __construct() {

		/* All CSS & JS enqueues have been moved to largo/inc/enqueue.php */

		add_filter(
			'post_gallery', array( &$this, 'handle_slideshow' ), 10, 2
		);

		if ( ! is_admin() )
			return;

		add_action('save_post', array( &$this, 'tag_post_as_slideshow' ), 10, 2);
		remove_shortcode('gallery');
		add_shortcode('gallery', array(&$this, 'handle_slideshow'), 10, 2);
	}

	/**
	 *
	 * @uses global $post WP Post object
	 */
	function handle_slideshow( $output, $attr ) {
		/**
		 * Grab attachments
		 */
		global $post;

		$this->slideshows += 1;

		$attr = shortcode_atts( array(
			'order' => 'ASC',
			'orderby' => 'menu_order ID',
			'id' => $post->ID,
			'itemtag' => 'dl',
			'icontag' => 'dt',
			'captiontag' => 'dd',
			'columns'  => 0,
			'size' => 'thumbnail',
			'link' => 'file',
			'ids' => ''
		), $attr );

		$id = intval( $attr['id'] );
		$order = ( $attr['order'] == 'ASC' ) ? 'ASC' : 'DESC';
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] )
				unset( $attr['orderby'] );
		}
		$size = sanitize_key( $attr['size'] );
		$ids = array_map( 'intval', explode(',', $attr['ids'] ) );
		$columns = $attr['columns'];

		// XXX: this could be factored out to a common function for getting
		// a post's images
		//if no IDs set, get attached posts
		if ( empty( $ids ) ) {
			$attachments = get_children( array(
				'post_parent'	=> $id,
				'post_status'	=> 'inherit',
				'post_type'	  => 'attachment',
				'post_mime_type' => 'image',
				'order'		  => $order,
				'orderby'		=> $orderby,
				'numberposts' => 200
			) );
		} else {

			$raw_attachments = get_posts( array(
				'post__in'		 => $ids,
				'post_type'	  => 'attachment',
				'post_mime_type' => 'image',
				'numberposts' => 200
			) );

			// If attachments are returned, put them into the array in the order specified
			if (is_array($raw_attachments)) {
				foreach ($ids as $id) {
					foreach ($raw_attachments as $attachment) {
						if ($id == $attachment->ID) {
							$attachments[(string) $id] = $attachment;
						}
					}
				}
			}
		}

		$column_label = 'none-up';
		if ( !empty( $columns ) ) {
			if ($columns == '0') {
				$columns = 'none';
			} else if ($columns == '1') {
				$columns = 'one';
			} else if ($columns == '2') {
				$columns = 'two';
			} else if ($columns == '3') {
				$columns = 'three';
			} else if ($columns == '4') {
				$columns = 'four';
			} else if ($columns == '5') {
				$columns = 'five';
			} else if ($columns == '6') {
				$columns = 'six';
			} else if ($columns == '7') {
				$columns = 'seven';
			} else if ($columns == '8') {
				$columns = 'eight';
			} else if ($columns == '9') {
				$columns = 'nine';
			}

			$column_label = $columns . '-up';
		}

		if ( empty( $attachments ) )
			return '';

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $id => $attachment )
				$output .= wp_get_attachment_link( $id, $size, true ) . "\n";
			return $output;
		}

		$postid = ($post->ID) ? $post->ID : rand(0,10000);
		$plink = get_permalink();
		$post_html_id = $postid . "-" . md5(
			$post->ID . $post->post_title . $post->post_content . $this->slideshows);

		$output .= '
			<div id="slides-' . esc_attr( $post_html_id ) . '" class="navis-slideshow ' . $column_label .'">';

		/*-- Add images --*/
		$count = 0;
		$total = count( $attachments );
		foreach ( $attachments as $id => $attachment ) {
			$count++;

			// Credit functionality provided by navis-media-credit plugin
			$credit = '';
			if ( function_exists( 'navis_get_media_credit' ) ) {
				$creditor = navis_get_media_credit( $id );
				$credit = $creditor->to_string();
			}

			$caption = $attachment->post_excerpt;
			$slidediv = $post_html_id . '-slide' . $count;
			$img_url = wp_get_attachment_url( $id );

			$output .= '<div id="' . esc_attr( $slidediv ) . '">';
			$output .= '<img data-lazy="' . esc_url( $img_url ) . '" />';

			if (!empty($credit))
				$output .= '<p class="wp-media-credit">' . wp_kses_post( $credit ) . '</p>';

			if (!empty($caption))
				$output .= '<p class="wp-caption-text">' . wp_kses_post( $caption ) . '</p>';

			$slide_link = get_permalink($post) . '#' . $post_html_id . '/' . $count;
			$output .= '<p class="permalink"><a href="' . $slide_link . '" class="slide-permalink"><i class="icon-link"></i> ' . esc_attr( __( 'permalink', 'largo' ) ) . '</a></p>';

			$output .= '</div>';
		}
		$output .= '</div>';

		return $output;
	}

	/**
	 * Applies the Slideshow custom taxonomy term to a post when it contains
	 * a gallery, and removes it when it doesn't.
	 *
	 * @param $post_ID ID of post
	 * @param $post Post object
	 * @todo add checks for post type, taxonomy existence, etc.
	 */
	function tag_post_as_slideshow( $post_ID, $post, $taxonomy = 'feature' ) {

		if ( ! is_object_in_taxonomy( $post->post_type, $taxonomy ) ) {
			return;
		}

		$ss_term = get_term_by( 'slug', 'slideshow', $taxonomy );
		$post_terms = wp_get_object_terms( $post_ID, $taxonomy );

		$new_post_terms = array();
		// if we have a [gallery] shortcode in our post
		if ( stripos( $post->post_content, '[gallery' ) !== false ) {
			$seen_ss = false;
			foreach ( $post_terms as $post_term ) {
				if ( $post_term->term_id == $ss_term->term_id ) {
					$seen_ss = true;
				}
				$new_post_terms[] = $post_term->slug;
			}

			if ( ! $seen_ss )
				$new_post_terms[] = $ss_term->slug;

		} else {
			$new_post_terms = array();
			foreach ( $post_terms as $post_term ) {
				if ( $post_term->term_id == $ss_term->term_id )
					continue;

				$new_post_terms[] = $post_term->slug;
			}
		}

		wp_set_object_terms( $post_ID, $new_post_terms, $taxonomy );
	}

}

new Navis_Slideshows;

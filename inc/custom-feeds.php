<?php
/**
 * Create a full text RSS feed even if site is using excerpts in the main feed
 * URL for full text feed is: http://mysite.org/?feed=fulltext
 *
 * @package Largo
 * @since 1.0
 */

function largo_full_text_feed() {
    add_filter('pre_option_rss_use_excerpt', '__return_zero');
    load_template( ABSPATH . WPINC . '/feed-rss2.php' );
}
add_feed('fulltext', 'largo_full_text_feed');
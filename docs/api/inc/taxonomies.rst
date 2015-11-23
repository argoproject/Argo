inc/taxonomies.php
==================

.. php:function:: largo_is_series_enabled()

   Check if the Series taxonomy is enabled

   :since: 0.4

   :returns: bool $hether or not the Series taxonomy option is enabled in the Theme Options > Advanced

.. php:function:: largo_is_series_landing_enabled()

   Check if Series landing pages are enabled

   :since: 0.5.2

   :returns: bool $hether or not the Series Landing Page option is enabled in the Theme Options > Advanced

.. php:function:: largo_custom_taxonomies()

   Register the prominence and series custom taxonomies
   Insert the default terms

   :uses: largo_is_series_enabled

   :since: 1.0

.. php:function:: largo_post_in_series()

   Determines whether a post is in a series
   Expects to be called from within The Loop.

   :uses: global $post

   :uses: largo_is_series_enabled

   :returns: bool

   :since: 1.0

.. php:function:: largo_custom_taxonomy_terms()

   Outputs custom taxonomy terms attached to a post

   :returns: array $f terms

   :since: 1.0

.. php:function:: largo_get_series_posts()

   Helper function for getting posts in proper landing-page order for a series

   :uses: largo_is_series_enabled
   :param integer $eries: term id
   :param integer $umber: of posts to fetch, defaults to all

.. php:function:: largo_series_landing_link()

   Filter: post_type_link

   Filter post permalinks for the Landing Page custom post type.
   Replace direct post link with the link for the associated
   Series taxonomy term, using the most recently created term
   if multiple are set.

   This filter overrides the wp-taxonomy-landing filter,
   which attempts to use the link for ANY term from ANY taxonomy.
   Largo really only cares about the Series taxonomy.

   :since: 0.5

   :returns: filtered $post_link, replacing a Landing Page link with its Series link as needed

.. php:function:: largo_get_series_landing_page_by_series()

   Helper to get the Series Landing Page for a given series.

   :param Object|id|string $series:

   :returns: array $n array of all WP_Post objects answering the description of this series. May be 0, 1 or conceivably many.

.. php:function:: largo_category_archive_posts()

   Helper for getting posts in a category archive, excluding featured posts.

   :param WP_Query $query:

   :uses: largo_get_featured_posts_in_category

.. php:function:: largo_get_featured_posts_in_category()

   Get posts marked as "Featured in category" for a given category name.

   :param string $category_name: the category to retrieve featured posts for.
   :param integer $number: total number of posts to return, backfilling with regular posts as necessary.

   :since: 0.5

.. php:function:: largo_featured_thumbnail_in_post_array()

   Return the first featured image thumbnail found in a given array of WP_Posts

   Useful if you wint to create a thumbnail for a given taxonomy

   :param array $n: array of WP_Post objects to iterate over

   :returns: str|false $he HTML for the image, or false if no images were found.

   :since: 0.5.3

   :uses: largo_has_featured_media

.. php:function:: largo_first_headline_in_post_array()

   Return the first headline link for an array of WP_Posts

   Useful if you want to link to an example post in a series.

   :param array $n: array of WP_Post objects to iterate over

   :returns: str $he HTML for the link

   :since: 0.5.3

.. php:function:: unregister_series_taxonomy()

   If the option in Advanced Options is unchecked, unregister the "Series" taxonomy

   :uses: largo_is_series_enabled

   :since: 0.4

.. php:function:: unregister_post_types_taxonomy()

   If the option in Advanced Options is unchecked, unregister the "Post Types" taxonomy

   :uses: of_get_option

   :since: 0.4
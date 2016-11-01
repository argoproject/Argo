inc/taxonomies.php
==================

.. php:function:: largo_is_series_enabled()

   Check if the Series taxonomy is enabled

   Is the series equivalent of the WordPress function is_category();
   We didn't call the function is_series() because it needs the largo_ prefix.

   :uses: global $post

   :uses: largo_is_series_enabled

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

   :since: 0.3

.. php:function:: largo_post_in_series()

   Determines whether a post is in a series.
   Expects to be called from within The Loop.
   Is the series equivalent of the WordPress function is_category();
   We didn't call the function is_series() because it needs the largo_ prefix.

   :uses: global $post

   :uses: largo_is_series_enabled

   :returns: bool

   :since: 0.3

.. php:function:: largo_custom_taxonomy_terms()

   Outputs custom taxonomy terms attached to a post

   :returns: array $f terms

   :since: 0.3

.. php:function:: largo_get_series_posts()

   Helper function for getting posts in proper landing-page order for a series

   :uses: largo_is_series_enabled
   :param integer $eries: term id
   :param integer $umber: of posts to fetch, defaults to all

   :since: 0.4

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
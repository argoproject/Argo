inc/featured-content.php
========================

.. php:function:: largo_get_featured_posts()

   Shorthand for querying posts from a custom taxonomy
   Used in homepage templates and sidebar widgets

   :param array $args: query args

   :returns: array $f featured post objects

   :since: 0.3

.. php:function:: largo_get_the_main_feature()

   Provides the "main" feature associated with a post.
   Expects to be called from within The Loop.

   :uses: global $post

   :returns: term $bject|false

   :since: 0.3

.. php:function:: largo_scrub_sticky_posts()

   If a post is marked as sticky, this unsticks any other posts on the blog
   so that we only have one sticky post at a time.

   If this ever breaks, #blamenacin.

   :param array $after: new list of sticky posts
   :param array $before: original list of sticky posts

   :returns: array

   :since: 1.0

.. php:function:: largo_have_featured_posts()

   Determine if we have any 'featured' posts on archive pages

.. php:function:: largo_have_homepage_featured_posts()

   Determine if we have any 'featured' posts on homepage

.. php:function:: largo_get_featured_posts_in_category()

   Get posts marked as "Featured in category" for a given category name.

   :param string $category_name: the category to retrieve featured posts for.
   :param integer $number: total number of posts to return, backfilling with regular posts as necessary.

   :since: 0.5

.. php:function:: largo_category_archive_posts()

   Helper for getting posts in a category archive, excluding featured posts.

   :param WP_Query $query:

   :uses: largo_get_featured_posts_in_category

   :since: 0.4
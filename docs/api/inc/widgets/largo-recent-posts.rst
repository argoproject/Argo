inc/widgets/largo-recent-posts.php
==================================

.. php:class:: largo_recent_posts_widget

      Largo Recent Posts

   .. php:method:: largo_recent_posts_widget::__construct()

      Register widget with WordPress.

   .. php:method:: largo_recent_posts_widget::widget()

      Outputs the content of the recent posts widget.

      :param array $args: widget arguments.
      :param array $instance: saved values from databse.

      :global: $post

      :global: $shown_ids $n array of post IDs already on the page, to avoid duplicating posts

      :global: $wp_query $sed to get posts on the page not in $shown_ids, to avoid duplicating posts
inc/term-meta.php
=================

.. php:function:: largo_get_term_meta_post()

   Get the proxy post for a term

   :param string $taxnomy: The taxonomy of the term for which you want to retrieve a term meta post
   :param int $term_id: The ID of the term

   :returns: int $post_id The ID of the term meta post

.. php:function:: largo_add_term_featured_media_button()

   Add the "Set Featured Media" button in the term edit page

   :since: 0.5.4

   :see: largo_term_featured_media_enqueue_post_editor

.. php:function:: largo_term_featured_media_enqueue_post_editor()

   Enqueue wordpress post editor on term edit page

   :param string $hook: the page this is being called upon.

   :since: 0.5.4

   :see: largo_term_featured_media_button

.. php:function:: largo_term_featured_media_types()

   Removes the embed-code, video and gallery media types from the term featured media editor

   :param array $types: array of media types that can be used with the featured media editor

   :since: 0.5.4

   :global: $post $sed to determine whether or not this button is being called on a post or on something else.

.. php:function:: largo_add_term_meta()

   Add meta data to a term

   :param string $taxonomy:
   :param int $term_id:
   :param string $meta_key:
   :param mixed $meta_value:
   :param bool $unique:

.. php:function:: largo_delete_term_meta()

   Delete meta data to a term

   :param string $taxonomy:
   :param int $term_id:
   :param string $meta_key:
   :param mixed $meta_value:

.. php:function:: largo_get_term_meta()

   Get meta data to a term

   :param string $taxonomy:
   :param int $term_id:
   :param string $meta_key:
   :param bool $single:

.. php:function:: largo_update_term_meta()

   Update meta data to a term

   :param string $taxonomy:
   :param int $term_id:
   :param string $meta_key:
   :param mixed $meta_value:
   :param mixed $prev_value:
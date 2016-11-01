inc/post-templates.php
======================

.. php:function:: is_post_template()

   Modelled on is_page_template, determine if we are in a single post template.
   You can optionally provide a template name and then the check will be
   specific to that template.

   :since: 0.3

   :uses: $wp_query
   :param string $template: The specific template name if specific matching is required.

   :returns: bool $rue on success, false on failure.

.. php:function:: largo_remove_hero()

   Remove potentially duplicated hero images in posts

   If the first paragraph of the post's content contains an img tag with a src,
   and if the src is the same as the src as the post featured media image, or if
   the src are different but the attachment IDs are the same, then remove the first
   paragraph from the post's content to hide the duplicate image.

   This does catch img tags inside shortcodes.

   This does not remove leading images that are different from the post featured media

   permanent in the database. (@see https://github.com/INN/Largo/issues/354)

   If you would like to disable this function globally or on certain posts,
   use the filter `largo_remove_hero`.

   :TODO: The $hanges to the content in this function should eventually be made

   :since: 0.4 $ in Largo's single-column template

   :since: 0.5.5 $ in Largo's two-column template
   :param String $content: the post content passed in by WordPress filter

   :returns: String $iltered post content.

.. php:function:: largo_url_to_attachmentid()

   Retrieves the attachment ID from the file URL
   (or that of any thumbnail image)

   :since: 0.4

   :see: https://pippinsplugins.com/retrieve-attachment-id-from-image-url/

   :returns: Int $D of post attachment (or false if not found)

.. php:function:: largo_get_partial_by_post_type()

   Given a post type and an optional context, return the partial that should be loaded for that sort of post.

   The default context is search, and the context isn't actually used by this function,
   but it is passed to the filter this function runs, largo_partial_by_post_type.

   :link: https://github.com/INN/Largo/issues/1023
   :param string $partial: Required, the default partial in this context.
   :param string $post_type: Required, the given post's post type
   :param string $context: Required, the context of this partial.

   :returns: string $he partial that should be loaded. This defaults to 'search'.

   :filter: largo_partial_by_post_type

   :since: 0.5.4
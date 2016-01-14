inc/images.php
==============

.. php:function:: largo_attachment_image_link_remove_filter()

   Remove links to attachments

   :param object $he: post content

   :returns: object $ost content with image links stripped out

   :since: 0.1

.. php:function:: largo_home_icon()

   Get the home icon for the sticky nav

   :param (string) $class: any additional classes you would like to add to icon when returned
   :param (string) $size: the size of the logo to return

   :returns: (string) $result markup for the sticky nav home icon (logo if available, otherwise just an icon)

   :since: 0.4

.. php:function:: largo_clear_home_icon_cache()

   Clear the home icon cache when options are updated

.. php:function:: largo_media_sideload_image()

   Similar to `media_sideload_image` except that it simply returns the attachment's ID on success

   :param (string) $file: the url of the image to download and attach to the post
   :param (integer) $post_id: the post ID to attach the image to
   :param (string) $desc: an optional description for the image

   :since: 0.5.2
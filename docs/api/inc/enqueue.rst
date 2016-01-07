inc/enqueue.php
===============

.. php:function:: largo_enqueue_js()

   Enqueue our core javascript and css files

   :since: 1.0

   :global: LARGO_DEBUG

.. php:function:: largo_enqueue_child_theme_css()

   Enqueue Largo child theme CSS

   :since: 0.5.4

.. php:function:: largo_enqueue_admin_scripts()

   Enqueue our admin javascript and css files

   :global: LARGO_DEBUG

.. php:function:: largo_header_js()

   Determine which size of the banner image to load based on the window width

   TODO: this should probably use picturefill for this instead

   :since: 1.0

.. php:function:: largo_footer_js()

   Additional scripts to load in the footer (mostly for various social widgets)

   :since: 1.0

.. php:function:: largo_google_analytics()

   Add Google Analytics code to the footer, you need to add your GA ID to the theme settings for this to work

   :since: 1.0
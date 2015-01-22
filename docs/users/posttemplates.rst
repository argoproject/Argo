Post Templates
==============

Default Templates
-----------------

Largo allows you to select between two default templates to use for posts and pages on your site. This default is set from the Appearance > Theme Options > Layout Options tab under the "Single Article Template" heading.

- **One Column (Standard Layout)** is a new default article template in Largo version 0.4 that focuses on readability, reduces distractions and allows for beautiful presentation of visual elements within a story with a large "hero" section at the top of the article for featured media (photo, video, slideshow or embedded media).
- **Two Columns (Classic Layout)** is the previous article template from Largo version 0.3 and before which features a content area on the left and a sidebar on the right.

Custom Templates
----------------

You can also select from either of the default templates or any custom page templates you may have registered on per-post/page basis. To change the template a given post or page is using, simply select the template you'd like to use from the Layout Options > Custom Sidebar dropdown on the post/page edit screen and then click "update".

In this dropdown you will notice that Largo comes packaged with a **"full width"** template that is useful for creating immersive stories where you might want to include your regular header and footer but then have a blank template to create a lot of custom markup and formatting and/or to embed a large map or photos. This layout is too wide by default to use for a regular article and has very poor readability so we do not recommend using it for that purpose.

The full width template also provides an example of how to register your own **custom post/page templates** by adding either "Template Name" (for pages, as is the default in WordPress) and/or "Single Post Template" (this extends the default WP functionality for pages to single posts as well) lines to the header block of a post/page template.

.. code::

    /*
    Template Name: Full Width Page
    Single Post Template: Full-width (no sidebar)
    Description: Shows the post but does not load any sidebars, allowing content to span full container width.
    */

 For more on custom post/page templates, see the related  `WordPress codex entry <http://codex.wordpress.org/Page_Templates>`_.
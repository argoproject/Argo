=============
Writing Posts
=============

As you create a post you can add formatting and enhance it in various ways. We'll start with the formatting tools for the main text, how to add images and other media, and then cover how to use the taxonomies and other post options. If you don't see all these options on the post edit page, click on Screen Options at the top and make sure the options you need are selected.

Formatting
==========

Text Formatting Options
-----------------------

Beyond using the toolbar in the Post Edit screen (in Visual mode), if you're comfortable editing HTML you can use some custom Largo classes (in Text mode) to style your text. 

See the Largo User's Guide for `more on these custom styles  <https://github.com/INN/Largo-User-Guide/blob/master/docs/style-guide.md>`_.

Module Wrapper
--------------

The module wrapper allows you to make a selection of text appear as an aside or a pull quote. To use it, select some text in Visual mode and click the Module Wrapper icon which is the furthest to the right in the formatting tool bar. You can then select:

* Aside, which pulls the text aside and wraps the other post content around it. This similar to a pull quote but with undecorated text.
* Pull Quote, which also pulls the selected text aside and applies styling to make it stand out from the body text.
* Embedded Media, which is useful for videos and other embedded content to make them resize responsively for different screen sizes. 

Use the module wrapper options to align your selection left, right, or center, and to display half-width or full-width. In the case of embedded content, you can choose to extract the width from the embed code itself but this will prevent it from resizing responsively.

*Tip: Preview the post to see how the module wrapper will display your content. You can use `undo` to revert changes made by the module wrapper, or by using Text mode you can delete the HTML wrapped around the selected content.*

Add Media
---------

The Add Media button above the body text area allows you to upload and insert images of various sizes anywhere in a post:

- Place the cursor where you want an image to appear in the text.
- Click the Add Media button, and either select from the existing Media Library or upload a new image.
- In the Insert Media screen, you can add a Caption, Description, Credit, Credit URL, Organization, and Alt Text. Alt Text is very important for meeting accessibility requirements and serving visually-impaired users.
- Also in the Insert Media screen, you can set the image alignment, add a link from the image, and set the image to full-size, medium, or thumbnail.

In addition to inserting images in posts, you can also add:

- Photo Galleries
- Audio Playlists
- Video Playlists

Note that uploads of media files are limited to 50 MB per file. In most cases it's better to embed videos rather than uploading them to a playlist.

Once an image or other media element is added to a post, you can click on it to edit as needed.

Featured Media
--------------

Featured media can more deeply engage your audience by getting their attention the moment they view the story page. A strong image or video also increases sharing on social networks and extends the reach and impact of your work. And images and other media are important elements in telling a story.

The standard WordPress site allows you to add a featured image to display at the top of each story page, as a thumbnail for each post on the homepage, etc. Largo extends this by allowing you to feature not just static images, but many kinds of media content (video, slideshows, and other embedded media).

Featured media will display at the top of the post page between the byline and the main text. For best visual results use a landscape-shaped image (or other media) with a width of 1170px.  Featured images will also display as cropped thumbnails on the home page or section page associated with the post. Note that featured videos, embed codes, and galleries will not display a home/section page thumbnail.

To add featured media, in the edit screen of your post click the Set Featured Media button. This opens a modal window where you have some options:

- You can enter embed code from any type of embeddable content. If you add a Title, Caption, and Credit, they’ll appear along with the embedded media.
- Featured video allows you to enter a Video URL from YouTube, Vimeo, or another video hosting service. If the embed code is not pulled in automatically you can enter it in the Video embed code field. You can add a custom thumbnail image for display on the home/section page, but note that the custom thumbnail won't display on the post page in place of the video itself.
- Featured image is typically used to include a "hero" image at the top of the post. For best results use a landscape image with a width of 1170px. 
- Featured gallery enables you to build a carousel of images. Select multiple images from the Media Library, or upload new images to use in the gallery. 

When uploading images you can click the Select Files button in the Upload Files tab, or just drag and drop images into the modal window. When using images for any purpose, make sure to add Alt Text to meet accessibility requirements for visually impaired website users. 

With all featured media you can add a title, caption, and other descriptive information for display with the media on the post page.


Taxonomies
==========

Taxonomies are a way to label and organize the posts on your site. Taxonomies activated by default in Largo include Categories, Tags, and Post Prominence. Two optional taxonomies, Series and Post Types, can be enabled through the Appearance > Theme Options > Advanced menu. 

Taxonomies do two important things:

- They add good metadata for search engine optimization and social media.
- They allow sorting of content on landing pages and widgets based on topic or content type.

The way Largo handles taxonomies is explained in detail on the Largo `Taxonomy documentation page <taxonomies.html>`_.

Categories and Tags
-------------------

After creating the body of the post, you should assign it to some Categories and Tags. Categories are top-level subjects, like Politics, Education, or Health. You can create new categories in the post edit screen and optionally assign it to a parent category. Be judicious, though, in creating categories. We recommend using no more than eight to 10 categories per site.

Tags can be much more granular, like Election 2016, Special Education, or Women's Health. You can even use tags for proper names and other very specific terms. Best practice is to capitalize each tag for consistency. As you type in the tag field, existing tags that match what you're typing till appear in a dropdown. If you see an exact match, select it instead of adding the same term again. There is no reason to be stingy with tags, so feel free to add as many to a post as you want.

Series
------

If you have enabled "Series" taxonomy in **Appearance > Theme Options > Advanced**, you'll have an option to assign each post to a Series. You can assign a post to an existing series, or add a new series. A series is generally a multi-part project that is only published for a set amount of time and then falls into the archive or a “projects” archive page. 

Post Types
----------

If you have enabled "Post Types" taxonomy in **Appearance > Theme Options > Advanced**, you'll have an option to assign each post to a Post Type. You can define post types any way you wish, for example for video, audio, commentary, infographic, etc. Like the other taxonomies each post type has a landing page displaying all posts assigned to that post type. 

In the post edit page you can assign the post to an existing post type, or add a new post type. You can also assign a post type to a parent post type, just as you can do with Categories and Series.

Related Posts
-------------

If you are using the Largo Related Posts Widget, you can add selected related posts by entering one or more post IDs separated by commas. To find the ID of a post, open it as if you were editing the post. In the browser address bar you'll see a number in the URL similar to _http://yoursite.org/wp-admin/post.php?post=31400&action=edit_. In this case 31400 is the post ID. 

_Note: If you are using the Largo Related Posts Widget and don't add related posts to any given post, the widget will display related posts based on a related series, category, or tag_.

Top Term
--------

From the Top Term dropdown menu (populated by categories and tags) select which term is primary for the post. This term appears directly above the headline on the post page, and links to the landing page for all posts assigned that top term.

Note that by default Top Term dropdown will display the category or tag that was assigned first while editing the post, regardless of how many other categories and tags are added. If you want to change this to a different term, you mush first either publish the post or save it as a draft. Then the Top Term dropdown will allow you to select a different term.

Other Post Options
==================

Custom Byline Options
---------------------

If you are posting for an author who doesn't have a WordPress user account for your website, you can enter their byline and optionally a link to a relevant webpage for that author. 

Note that this option should be used very rarely.

Wherever possible we recommend creating a WordPress account for each author. 

If you find that you need to include co-authors, you should activate the `Coauthors Plus plugin <plugins.html>`_. This allows WordPress to create an author archive page with all posts by this author.

If none of these options work, you can enter the byline text and (optionally) byline link in the Custom Byline Options box to override the display of the byline. Note that this will override display of the user entering the post, and will not add the post to an author archive page.

Layout Options
--------------

The default post template since Largo 0.4 is the One Column (Standard) layout. In this box you can choose a different layout for the post. Read more here about the alternative `post layout options <themeoptions.html#layout-options>`_.

Custom Sidebar
--------------

The default (single column) post layout does not include a sidebar. If you select a sidebar from this dropdown menu it will be displayed as a column on the left of the post beginning below the hero image.

For the two column post template, the sidebar is displayed to the right of the main post content.

Post Prominence
---------------

This is used to determine how and where posts are displayed on the site (for example, top stories on the homepage or featured content widgets in a sidebar or footer). For more on Post Prominence see the `Taxonomy documentation page <taxonomies.html#post-prominence>`_.

More Details on Posts, Media, and Formatting
--------------------------------------------

See the Largo User's Guide for more on:

- `Using Largo custom styles <https://github.com/INN/Largo-User-Guide/blob/master/docs/style-guide.md>`_
- `Structuring Posts by using Headings <https://github.com/INN/Largo-User-Guide/blob/master/docs/post-structure-headings.md>`_
- `A Tour of the Post Edit Screen <https://github.com/INN/Largo-User-Guide/blob/master/docs/publish-content-part-one.md>`_
- `Post Text Formatting <https://github.com/INN/Largo-User-Guide/blob/master/docs/publish-content-part-two.md>`_
- `Images and Media in Largo Posts <https://github.com/INN/Largo-User-Guide/blob/master/docs/images-and-media.md>`_
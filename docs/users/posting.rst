Writing Posts
=============

Formatting Within Posts
-----------------------

As you create a post you can add formatting and enhance it in various ways. 

**Module Wrapper**

The module wrapper allows you to make a selection of text appear as an aside or a pull quote. To use it, select some text in Visual mode and click the Module Wrapper icon which is the furthest to the right in the formatting tool bar. You can then select:

* Aside, which pulls the text aside and wraps the other post content around it. This similar to a pull quote but with undecorated text.
* Pull Quote, which also pulls the selected text aside and applies styling to make it stand out from the body text.
* Embedded Media, which is useful for videos and other embedded content to make them resize responsively for different screen sizes. 

Use the module wrapper options to align your selection left, right, or center, and to display half-width or full-width. In the case of embedded content, you can choose to extract the width from the embed code itself but this will prevent it from resizing responsively.

*Tip: Preview the post to see how the module wrapper will display your content. You can use `undo` to revert changes made by the module wrapper, or by using Text mode you can delete the HTML wrapped around the selected content.*

**Add Media**

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

**Featured Media**

Featured media can more deeply engage your audience by getting their attention the moment they view the story page. A strong image or video also increases sharing on social networks and extends the reach and impact of your work. And images and other media are important elements in telling a story.

The standard WordPress site allows you to add a featured image to display at the top of each story page, as a thumbnail for each post on the homepage, etc. Largo extends this by allowing you to feature not just static images, but many kinds of media content (video, slideshows, and other embedded media).

Featured media will display at the top of the post page between the byline and the main text. For best visual results use a landscape-shaped image (or other media) with a width of 1170px.  Featured images will also displayas cropped thumbnails on the home page or section page associated with the post. Note that featured videos, embed codes, and galleries will not display a home/section page thumbnail.

To add featured media, in the edit screen of your post click the Set Featured Media button. This opens a modal window where you have some options:

- You can enter embed code from YouTube, Vimeo, and other embeddable video sources, or from slideshows and other embeddable content. If you add a Title, Caption, and Credit, they’ll appear along with the embedded media.
- Featured video allows you to enter a Video URL from YouTube, Vimeo, or another video hosting service. If the embed code is not pulled in automatically you can enter it in the Video embed code field. You can add a custom thumbnail image for display on the home/section page, but note that the custom thumbnail won't display on the post page in place of the video itself.
- Featured image is typically used to include a "hero" image at the top of the post. For best results use a landscape image with a width of 1170px. 
- Featured gallery enables you to build a carousel of images. Select multiple images from the Media Library, or upload new images to use in the gallery. 

When uploading images you can click the Select Files button in the Upload Files tab, or just drag and drop images into the modal window. When using images for any purpose, make sure to add Alt Text to meet accessibility requirements for visually impaired website users.


Taxonomies
------------------

Taxonomies are a way to label and organize the posts on your site. Taxonomies activated by default in Largo include Categories, Tags, and Post Prominence. There are two optional taxonomies, Series and Post Types, that can be enabled through the Appearance > Theme Options > Advanced menu. 

Taxonomies do two important things:

- They add good metadata for search engine optimization and social media.
- They allow sorting of content on landing pages and widgets based on topic or content type.

The way Largo handles taxonomies is explained in detail on the Largo `Taxonomy documentation page <taxonomies.html>`_.

**Categories, Tags, and Series**

After creating the body of the post, you should assign some Categories and Tags to it. If you are using the Series or Post Tyoe taxonomy assign the post to the relevant series and/or post type.

**Related Posts**

If you have enabled the Largo Related Posts Widget, you can add selected related posts by entering one or more post IDs separated by commas. To find the ID of a post, open it as if you were editing the post. In the browser address bar you'll see a number in the URL similar to `http://yoursite.org/wp-admin/post.php?post=31400&action=edit`. In this case 31400 is the post ID. 

Note: If you are using the Largo Related Posts Widget and don't add related posts to any given post, the widget will display related posts based on series, category, or tag.

Show related posts that are either editorially determined (by adding related post IDs in the Additional Options box of the post edit screen) or using a default related algorithm that tries to surface the most closely-related post(s) to a given post by series, category or tag.

**Top Term**

From a pulldown menu (populated by categories and tags) Identify which of the post's terms is primary. This is used a navigational aid in many homepage layouts and appears directly above the headline on the post page, providing a link to the landing page for all posts assigned that top term.

**Custom Byline Options**

If you are posting for an author who doesn't have a WordPress user account in your website, you can enter their byline and a link to a relevant webpage for that author. 

We recommend creating a WordPress account for each author, which allows WordPress to create an author archive page with all the author's posts. If you need to include co-authors, you  should activate the `Coauthors Plus plugin <plugins.html>`_. 

Using the Custom Byline Option will override display of the user entering the post, and will not add the post to an authos archive page.

**Layout Options**

The default post template since Largo 0.4 is the One Column (Standard) layout. In this box you are able to modify the template on a per-post basis by selecting another option.

Read more here about the `Single Article Template <themeoptions.html#layout-options>`_.

**Custom Sidebar**

The default (single column) post layout does not include a sidebar. If you select a sidebar from this dropdown menu it will be displayed as a column on the left of the post beginning below the hero image.

For the two column post template, the sidebar is displayed to the right of the main post content.

**Post Prominence**

This is used to determine how and where posts are displayed on the site (for example, top stories on the homepage or featured content widgets in a sidebar or footer). For more on Post Prominence see the `Taxonomy documentation page <taxonomies.html#post-prominence>`_.

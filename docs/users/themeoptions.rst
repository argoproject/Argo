Theme Options
==============================

When you first activate the Largo theme, there are a number options that need to be configured before you make the site live. The majority of these can be found in the **Appearance** > **Theme Options** menu which you can access from the left sidebar of the WordPress administration interface.

The Theme Options page is organized into four sections which you can access by clicking on the relevant tab across the top of the page: Basic Settings, Theme Images, Layout Options and Homepage Options.

Basic Settings
--------------

**Site Description** - This is a short description of your site that is used in a sidebar or footer widget. Ideally this should just be a short paragraph (1-2 sentences in length) and you can include HTML in this box to link to the "About" page of your site so that visitors can read more about your organization.

**Feed URL** - This is a link to the main RSS feed for your site. By default this will be http://yoursite.com/feed but if you use a feed management and/or analytics tool (such as Feedburner), you can replace the default link here and it will be used in all relevant places on your Largo site.

**Donate Button** - The Largo theme includes an optional donate button in the top header. To enable the donate button, make sure the checkbox to show the donate button is checked and then add the link to your donation page, form or external payment processor here. Optionally, you can change the text of the button. The Largo theme also includes a sidebar widget that you can use to link to a donation page in addition to or instead of the link in the top header.

**Don't Miss Menu** - Under the main navbar on your Largo site is an optional secondary navigation menu that, by default, is called "Don't Miss". To enable this menu make sure the checkbox to show the Don't Miss Menu is checked. Optionally, you can customize the label that appears at the beginning of the menu or remove it entirely. To add or remove links from this menu visit Appearance > Menus from the left sidebar in the WordPress administration interface.

**Footer Nav Menu** - On the left side of the site footer is a configurable menu area. By default the label for this menu will be your site name, but you can change it here. As with the Don't Miss menu area, to add or remove links from this menu visit Appearance > Menus from the left sidebar in the WordPress administration interface.

**Sticky Nav** - The sticky navigation bar remains at the top of the reader's window as they scroll. The default is to show the sticky navbar, but you may want to hide it. You also have the option to show your site name in the sticky navbar, which is useful on smaller screens.

**Copyright Message** - By default this will display "Copyright [YEAR], Your Site Name" but you can enter your own message here if you would like. You can include HTML in this area to link to external sites and use &copy; to display a copyright symbol or ``%d`` to display the current year.

**Google Analytics** - The Largo theme has built in support for Google Analytics. Enter your Google Analytics ID here and the relevant Google Analytics code will be automatically added to all of the pages on your site. Note that it is configured to not track logged in users to ensure accurate reporting.

**Word to use for "Posts"** - By default, WordPress calls single article pages "posts" but you might prefer to use another name. You can specify the singular and plural forms separately.

**Social Media Links** - These are links to relevant social media profiles for your site or organization. These are used in a sidebar widget to provide links to like or follow your organization on Facebook and Twitter, in bylines to attribute content to your organization and in special code in the header to make sure your content appears optimally when shared by other users on these social networks. 

Be careful to note the recommended format for each link type for maximum compatibility. These icons are by default used in the footer of your site's pages, but you have the option to show them in the header.

Note that authors can add links to their own social media profiles by editing their user profile.

**Single Post Social Icons** - By default a box showing social media links will be shown at the top of single article pages. You can choose to hide this if you prefer. You can also choose which share icons should be displayed here, the verb used on Facebook buttons, whether or not your Twitter share count is displayed, and where the "Clean Read" link should be displayed on the page.

In previous versions of Largo, the option to have the author's bio and social media links occupied this slot, and also governed the visibility of share icons and the author bio at the end of the article. The article-bottom author bio and social links are now available as widgets.

Theme Images
------------

This section allows you to upload images that are used primarily in the top header of your Largo site. To add your images:

- Make sure you have created all five image sizes as outlined in our :doc:`prelaunchchecklist` and then click "Upload" by the image you want to add.

	- 200x200px Square default thumbnail image
	- 16x16px Favicon
	- 768px-wide Small banner image
	- 980px-wide Medium banner image
	- 1170px-wide Large banner image

- Drag and drop the image onto the uploader (or click "Select Files" and find the correct image on your computer). When the image has finished uploading, make sure you have selected the full size image and then click the button at the bottom of the uploader that says "Use This Image".

- If the image has uploaded correctly, you should see a thumbnail version of it and the link to the photo in the field next to the "upload" button.

- Once you have uploaded all five images, be sure to click "Save Options" to save your changes.

There is one additional option in this section, a checkbox that allows you to use text in the place of the banner images. It is unlikely that you will use this option, but if you do, selecting this checkbox will use the Site Title and Description from your **Settings** > **General** menu in the place of the the header images so make sure that you have set those options before you enable this feature.

.. _pre-launch checklist: :doc:`./prelaunchchecklist.rst`

Layout Options
--------------

**Home Template** - This choice determines what the top of your website's main page looks like. The Largo theme currently offers five homepage templates:

- **Blog** - This displays your most recent posts in reverse chronological order (newest at the top) with the ability to make a post "sticky" so it stays at the top of the homepage.
- **Big story, full-width image**: Prominently features the top story by itself, with a full-width image, headline and excerpt.
- **One Big Story and list of featured stories**: Prominently features the top story along with three other 'Featured on Homepage' items, or by itself if none are specified. Best with Homepage Bottom set to 'blank'
- **One big story and list of stories from the same series**: Prominently features the top story along with other posts in its series along the right side. Requires the :ref:`series-tax` taxonomy to be enabled.
- **Top Stories** - If you select this layout you will want to ensure that you are adding featuring images and excerpts for all of your posts and that you have at least six posts at all times set to "Homepage Featured" in the Post Prominence taxonomy and at least one post (that MUST have a featured image set) marked as the "Top Story", also in the Post Prominence taxonomy.

**Sticky Posts** - If enabled, the top sticky post will displayed in between the Homepage Template and the Homepage Bottom, below the tag "Featured". Posts can be marked sticky by opening the post editor, going to the "Publish" metabox, clicking "Edit" next to "Visibility", then choosing "Public" and "Stick this post to the front page."

**Homepage bottom templates** - Largo supports three options for the bottom of the homepage:

- A single-column list of recent posts with photos and excerpts
- A two-column widget area: This creates a new widget area in **Appearance > Widgets** that can be filled with widgets. It appears empty until widgets have been added to this area.
- Nothing whatsoever

**Category and Tag Display** - Largo can display a single category or tag above the headline for each story, a list of tags below the story's excerpt or nothing at all.

**Number of posts** - The number of posts displayed on the main area of the homepage, not counting posts in the top area of the homepage or in the sticky box. THe default is 10.

**Categories to include or exclude** - enter a comma-separated list of category ID numbers here to exclude them from the front-page listing. in the main loop on the homepage (comma-separated list of values, see: http://bit.ly/XmDGgd for correct format).

Deprecated Options
------------------

The following homepage layout templates are no longer included in Largo:

- **Slider**: An animated carousel of featured stories with large images. This should be automatically updated to the "Blog" template after upgrading Largo.


Homepage Options
----------------



Homepage display options
- Display options for categories and tags on posts on the homepage
- A single category or tag above the headline for each story
- A list of tags below the story's excerpt
- No tags or categories

- Number of posts to display in the main posts area on the homepage
- Categories to include or exclude from the main posts area on the home page. Enter a comma-separated list of category names or ids:

  ``news,sports,12,13,press-releases,blog``

**Sidebar options**:
These affect the presentation of the sidebar to the reader.
- Add a third sidebar used only on archive pages (category, tag, author and series pages), configurable in Appearance > Widgets
- An additional widget region just above the site footer region, configurable in Appearance > Widgets
- Fade the sidebar out on single story pages as the reader scrolls

**Footer layout**

[[footer-options.png]]

The default footer is a 3 column footer with a wide center column. Alternatively you can choose to have 3 or 4 equal columns. Each column is a widget area that can be configured under the *Appearance* > *Widgets* menu, where they will be labeled "Footer 1" through "Footer 3" or "Footer 4."

**Advanced Options**
- Enable ``[[custom LESS compilation for theme customization|Modifying Largo styles]]``
- Enable ``[[custom landing pages for series and projects|Custom landing pages]]``
- Enable the _`Series` taxonomy.
- Set the default region in the left-hand column of landing pages
- Set the default region in the right-hand column of landing pages
- Replace WordPress search with `Google Custom Search <https://support.google.com/customsearch/answer/2630963?hl=en&ctx=topic>`_. This is highly recommended.


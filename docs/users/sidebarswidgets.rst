====================
Sidebars and Widgets
====================

Overview
--------

Largo adds a number of widget areas and custom widgets to allow for easy, drag and drop management of content blocks on your site.

Access and edit any of the following widget areas from the Appearance > Widgets menu in the WordPress Dashboard.

To add widgets to any of these areas, simply drag and drop a widget from the area on left to the widget area you want it to appear in. Note that as soon as you add any widgets to a widget area, the default will no longer display so you will need to completely populate the widget area with the widgets you want to display. Many widgets will have additional settings you can use to configure how they appear on your site.

Note that some widgets are small and can easily fit in narrow columns. Other widgets might contain lots of content that doesn’t fit well within in a small space. It’s important to see how a widget affects the page layout and adjust as needed.

For more about widgets and how WordPress handles them, see `the WordPress Codex article on widgets <http://codex.wordpress.org/WordPress_Widgets>`_.

Widget Areas
------------

**Sidebar Widget Areas**

Note that the way some of these widget area appear on your site will depend on the layout options you set in the Appearance > Theme Options > Layout Options menu.

- **Main Sidebar** - By default this is the sidebar used for all non-single pages (homepage, category pages, date archive pages, etc.)

- **Single Sidebar** - Used on single posts and pages. Note that if you do not populate this widget area, Largo will fallback to using the Main Sidebar instead. Additionally, as of Largo version 0.4, the recommended default layout for single posts and pages is a single column layout that does **not** include a sidebar unless you explicitly set one from the Layout Options > Custom Sidebar dropdown menu when editing an individual post. If you select a sidebar from this dropdown menu, it typically appear as a skinny column floated to the left of your content.
- **Topic Sidebar** - An optional widget area enabled from the Appearance > Theme Options > Layout Options menu. When enabled, this widget area will be used in the place of the main sidebar on all category, tag, and custom taxonomy (e.g. - series) pages.

**Footer Widget Areas**

Depending on which layout you select in the Appearance > Theme Options > Layout Options menu for the Footer Layout option, you will see either three or four numbered footer widget areas (which are numbered left to right). These areas will typically be populated by some default widgets that you can modify or change by adding widgets of your choice in the Appearance > Widgets menu.

**The Article Bottom Widget Area**

Prior to version 0.4, Largo controlled the appearance of elements at the bottom of article pages using various settings from the Appearance > Theme Options > Basic Settings menu. In version 0.4 we have made this a widget area instead to allow for more flexibility in the type and order of elements that appear here.

By default, the only thing displayed at the bottom of an article is the comments section (when comments are enabled). Some of the elements you might consider adding to this area are the author bio, related posts and prev/next links widgets but many of the widgets in WordPress or those added by Largo are designed to be contextual and display well in this area so you can experiment and see what best suits your needs.

**Less Common Widget Areas**

- **Homepage Alert** - For sites that cover breaking news, this is an optional widget area where you can add a text widget to add a "breaking" banner to the top of the homepage. The styling for this widget area is very basic so if you plan to use it you'll likely want to create either some custom CSS for a text widget and/or create and register your own "breaking news" widget to be used in this widget area.
- **Header Ad Zone** -  If you have enabled the optional header leaderboard ad zone from the Appearance > Theme Options > Advanced tab then this would be the widget are you'll use to add an ad widget to appear in that position.
- **Homepage Left Rail** - If you are using a three column homepage layout this will be a widget area to manage the contents of the skinny column to the far left.

**Custom Widget Areas**

Largo also enables you to add any number of **custom widget areas** you might need for display on certain pages of your site. For example, you might want to create a sidebar for a category or series that is only displayed on the archive page for that category/series and/or on the posts that appear in that category/series. Custom sidebars can be added from the Appearance > Theme Options > Layout Options tab under the "Sidebar Options" header. Instructions for settings these options can be found below.

Custom Widgets
--------------

Largo adds a number of custom widgets in addition to the `standard widgets <http://codex.wordpress.org/Widgets_SubPanel>`_ that come included with WordPress.

All of our widgets have:

- The choice of three backgrounds (default, reverse and none) to give you a variety of styling options and classes to use for custom CSS.
- The ability to be hidden on desktops, tablets and phones using the responsive utility classes `from Twitter Bootstrap <http://getbootstrap.com/2.3.2/scaffolding.html#responsive>`_. We recommend hiding less necessary widgets for users on smaller viewports such as mobile devices in order to create a cleaner, simpler experience that allows them to focus on your content without distraction.
- The ability to set a link for the widget title.

The widgets added by Largo include:

**INN Member Stories**

Shows a list of curated stories from other members of INN. By default this widget will display headlines, source, and date of the three recent stories from INN members. Options include showing excerpts and adjusting the number of stories to show.

**Largo About Site**

Displays the site description provided in the Appearance > Theme Options > Basic Settings menu.

**Largo Author Bio**

Shows a bio of the author(s) for a given post including their photo and social media links (when filled out in their user profile). Also includes a "More by author" link to the landing page for all posts by the author. This widget only works on single-post pages.

**Largo Disclaimer**

When the "Enable Disclaimer Widget" option is enabled from the Appearance > Theme Options > Advanced menu, this widget will show the article disclaimer you have provided. You can change the disclaimer on a per-article basis by modifying it in the post edit screen.

**Largo Donate Widget**

Shows a donate message and button with a link to a donation page. You can change the message, button text, and/or link on a per-widget basis if you need to for different pages/sections of your site.

**Largo Explore Related**

A tabbed widget to show related stories by category/tag. This widget works only on single-post pages, and fits best in the Article Bottom widget area. We recommend using the Largo Related posts widget instead but this widget is retained for backwards compatibility.

**Largo Facebook Widget**

Shows a Facebook "like" box/feed. This will only work for Facebook Pages, which are by default public, not personal Facebook accounts. If you get an error message saying "Error: Not a valid Facebook Page url," it typically means the url is not a public Facebook Page.

**Largo Featured Posts**

Show posts assigned a Post Prominence, with titles, thumbnails and excerpts. By default Largo has five Post Prominence terms: *Featured in Category, Featured in Series, Footer Featured Widget, Homepage Featured, and Sidebar Featured Widget*. (You can add new Post Prominence terms in Posts > Post Prominence.) Use these to display posts you want to feature on different pages. For example you can place this widget in the Main Sidebar, and set it to display posts assigned to Homepage Featured. Posts assigned the Prominence Term of Homepage Featured will then display in this widget. You could then place another Largo Featured Posts widget in the Topic Sidebar (after enabling it from the Appearance > Theme Options > Layout menu > Sidebar Options), and set it to display posts assigned the Prominence Term of Featured in Category.

In short, you can use the Featured Posts widget to feature different posts in various types of pages. Other options for this widget include changing the title (defaults to "In Case You Missed It"), changing the number of posts to show and the excerpt length, and Thumbnail location.

**Largo Follow**

Uses the social media links provided for your site in the Appearance > Theme Options > Basic Settings menu to show buttons to follow you on select social networks. 

**Largo Image Widget**

The Largo Image Widget allows you to place an image in any widget area, along with a title and text caption. This can be useful to promote something else on your website or on another site, or to create a custom message or ad. To begin just select an image in the widget settings and begin configuring. You can add a hyperlink from the image to any url, and choose to have the url open in the same window or a new window. You can choose a preset image size or set a custom size, and set the image alignment in relation to the caption text. 

As with all images on your website, please be sure to add Alternate Text to tell visually impaired users what the image is. This should be a short phrase or sentence, similar to how you would describe the image to someone over the phone.

**Largo Post Series Widget**

This widget is useful for single-post pages to show the title and description of the series the post belongs to. If the post has not been assigned to a series, the widget will display nothing.

**Largo Prev/Next Links** 

Most commonly used in the Article Bottom widget area, this will show links to the next and previous posts ordered by published date.

**Largo Recent Comments**

This widget simply shows recent comments, with links to the posts they appear on. Besides the standard widget options, you can set the number of comments to display in the widget.

**Largo Recent Posts**

This is a powerful widget to show recent posts in various formats with the option to limit by category, tag, custom taxonomy term and/or author. This widget has many options that enable display of a filtered set of articles or excerpts based on criteria of your choosing. You can limit by author and/or category, and then further limit by tag. You can limit by custom taxonomy (Post Prominence, Series, or Post Types (the latter two need to be enabled in Appearance > Theme Options > Advanced), and you can combine these filters as needed. 

Limiting by taxonomies and their terms requires using the "slug" for each. To start with, here are the available taxonomies with their names and slugs:

===============   ======================================================
Taxonomy Name     Taxonomy Slug
===============   ======================================================
Categories        category
Tags              post_tag
Post Prominence   prominence
Series            series
Post Types        post-type
===============   ======================================================

Each term within a taxonomy also has a name and a slug. For example, the slug for a tag of "social media" would be "social-media". You can find the slugs for the terms in any taxonomy by checking its settings page, which lists the names and their slugs.

If you want to limit by custom taxonomy, enter the taxonomy's slug in the Taxonomy field, and then the term's slug in the Term field. For example if you want to display Post Prominence content assigned to "Featured in Series", you'll enter "prominence" as the Taxonomy and "series-featured" as the Term. 

After setting the limits on the content you want displayed, you can adjust how it's displayed.  You can set how thumbnails, excerpts, bbylines, and top terms are displayed, and add a More link to a URL. One additional setting may be very helpful: Depending on how you limit by taxonomy etc., you may want to select the option to Avoid Duplicate Posts.

**Largo Related Posts**

This widget works on single-post and Series pages. It shows the title and thumbnail image for related posts.  Related posts can be set manually by adding related post IDs in the Additional Options/Related Posts box of the post edit screen. If no related posts are set, the widget will back to a default algorithm that selects the most closely-related posts based on series, category or tag. Widget options include changing its title (defaults to "Read Next"), the number of related posts to display, and the related post Thumbnail position.

**Largo Series Posts**

Displays links to up to five posts in the series selected. The first link will include the post title and excerpt, and a thumbnail of the Featured Image if one is included in the post. You can also choose to show the date with the first post link. The remaining post links are displayed as a simple unordered list under a customizable heading, which defaults to "Explore". 

**Largo Staff Roster**

Displays a list of users on your site, with a thumbnail image, name, and a link to a page containing each user's posts. Widget options include selecting specific user groups, and changing the title displayed with the widget ( defaults to "Staff Members").  Note that you can exclude specific users from being displayed in the widget by going to Users > Edit User and in the Staff Status setting selecting "Hide in roster". 

**Largo Tag List**

Typically used in the Article Bottom widget area, this will display a list of categories and tags associated with a given post. Each term in this list links to the archive page for the term. Widget options include changing title of the list, and setting the maximum number of terms to show.

**Largo Taxonomy List**

List all of the terms in a given taxonomy with links to their archive pages. This is most commonly used to generate a list of series/projects with links to their project pages. To use this widget begin by entering in the Taxonomy field the slug of the taxonomy you want to use. For example, the slug for Categories is "category"; the slug for Tags is "post_tag"; the slug for Post Prominence is "prominence"; and the slug for Series is "series". You must enter one of these slugs for the widget to function correctly. 

By default the widget will pull in *all* posts in the taxonomy, which could be a very large number of posts. Use the Count field to limit the number of posts displayed. You can also limit the display to specific terms in the taxonomy. To do this you must find the term's ID by visiting the list of terms in the taxonomy (under Posts in the dashboard), then hover over or click on the term and find the tag_ID number in the URL for that term. 

For example, in this URL for the term "Bacon" the term ID is 482:

	``/wp-admin/edit-tags.php?action=edit&taxonomy=post_tag&tag_ID=482&post_type=post``

After setting the taxonomy slug, count, and optionally limiting by term ID, you choose to display thumbnails and a headline of the most recent post in the taxonomy, or display the taxonomy list as as dropdown menu. The Title of the widget defaults to Categories, but you can override this with a title of your choice.

**Largo Twitter Widget**

Allows for the display of a Twitter profile, list or search widget. Note that to use this widget you'll need to create a Twitter widget and grab its ID from https://twitter.com/settings/widgets. Each widget on Twitter has a URL with a long string of numbers. That's the Twitter Widget ID, so copy and past that number into the Largo Twitter Widget. 

On Twitter you can create widgets for a user timeline, favorites, list, or search. In the Largo Twitter Widget, set the Widget Type for the type you want and paste in the Twitter Widget ID.

*Note: In most cases the Largo Twitter Widget will work fine if you just set the Twitter Widget ID. As a fallback in case of errors loading scripts from Twitter, it's a good idea to also add the Twitter Username, List slug, and search query in the settings*.

**Largo Roundups Widget**

If you have the **Link Roundups** plugin installed, this widget will display the most recent Link Roundup posts. You can change the number of posts to show, limit display to a category, and add a More link at the bottom of the widget. 

For more on how this works see the `Link Roundups widget documentation <https://github.com/INN/link-roundups/blob/master/README.md>`_.


Widgets Deprecated in 0.4:
--------------------------

- **Largo Footer Featured Posts** - Works similarly to the Featured Widget above but limited to the "footer featured" term in the prominence taxonomy.
- **Largo Sidebar Featured Posts** - Works similarly to the Featured Widget above but limited to the "footer featured" term in the prominence taxonomy.

Sidebar Options
---------------

Under the Appearance > Theme Options > Layout menu you will find a section labelled "Sidebar Options". This area has a few options to configure the widget areas on your site:

- A checkbox to activate the "Topic Sidebar" as described above.
- An option to include an optional widget region ("sidebar") just above the site footer. This can be used by a few sites to add sponsor logos or additional ad units, etc.

You can also easily register custom sidebar regions, which will then be available as widget regions in Appearance > Widgets, and as sidebars in posts. This is useful if you want to create additional widget areas for particular categories or special projects on your site. 

To add a new widget area, simply add a name in the textbox with each widget area you'd like to register on a new line and then click "Save Options".

Once you have added custom widget areas you can add widgets to them from the Appearance > Widgets menu. On the post edit page you can select them as sidebars from the Layout Options > Custom Sidebar dropdown, or from the Archive Sidebar dropdown when adding or managing a category, tag, or series.

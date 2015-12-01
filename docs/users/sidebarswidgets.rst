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
- **Topic Sidebar** - An optional widget area enabled from the Appearance > Theme Options > Layout Options menu. When enabled, this widget area will be used in the place of the main sidebar on all category, tag and custom taxonomy (e.g. - series) pages.

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

- **INN Member Stories** - Shows a list of curated stories from other member of INN.
- **Largo Author Bio** - Shows a bio of the author(s) for a given post including their photo and social media links (when filled out in their user profile).
- **Largo Explore Related** - A tabbed widget to show related stories by category/tag. We recommend using the Largo Related posts widget instead but this widget is retained in Largo version 0.4 for backwards compatibility.
- **Largo Featured Posts** - Show recent featured posts with thumbnails and excerpts.
- **Largo Recent Comments** - Show recent comments with links to the posts they appear on.
- **Largo Related Posts** - Show related posts that are either editorially determined (by adding related post IDs in the Additional Options box of the post edit screen) or using a default related algorithm that tries to surface the most closely-related post(s) to a given post by series, category or tag.
- **Largo Staff Roster** - Display a list of the users on your site with options to limit by user role or exclude particular users by setting an option in their user profile.
- **Largo Taxonomy List** - List all of the terms in a given taxonomy with links to their archive pages. This is mostly commonly used to generate a list of series/projects with links to the project pages.
- **Largo About Site** - Displays the site description provided in the Appearance > Theme Options > Basic Settings menu.
- **Largo Donate Widget** - Shows a donate message and button. The default message and link used in this widget can be configured in the Appearance > Theme Options > Basic Settings menu but can be overridden on a per-widget basis if you want to show different messages on different pages/sections of your site.
- **Largo Facebook Widget** - Shows a Facebook "like" box/feed.
- **Largo Follow** - Uses the social media links provided for your site in the Appearance > Theme Options > Basic Settings menu to show buttons to follow you on select social networks
- **Largo Prev/Next Links** - Most commonly used in the Article Bottom widget area, this will show links to the next/prev post ordered by published date.
- **Largo Recent Posts** - A powerful widget to show recent posts in various formats with the option to limit by category, tag, custom taxonomy term and/or author.
- **Largo Tag List** - Typically used in the Article Bottom widget area, this will display a list of tags associated with a given post.
- **Largo Twitter Widget** - Allow for the display of a Twitter profile, list or search widget. Note that to use this widget you'll need to create a widget (and grab the widget ID) from https://twitter.com/settings/widgets.
- **Largo Disclaimer Site** - When the "Enable Disclaimer Widget" option is enabled from the Appearance > Theme Options menu, this widget will show the article disclaimer you have provided. Optionally, you can override the disclaimer on a per-article basis by modifying it from the post edit screen.

Deprecated in 0.4:

- **Largo Footer Featured Posts** - Works similarly to the Featured Widget above but limited to the "footer featured" term in the prominence taxonomy.
- **Largo Sidebar Featured Posts** - Works similarly to the Featured Widget above but limited to the "footer featured" term in the prominence taxonomy.

Sidebar Options
---------------

Under the Appearance > Theme Options > Layout Options menu you will find a section labelled "Sidebar Options". This area has a few options to configure the widget areas on your site:

- A checkbox to activate the "Topic Sidebar" as described above
- An option to include an optional widget area directly above the footer (used by a few sites to add sponsor logos or additional ad units).
- An option to fade the sidebar on single post pages with a user scrolls

And most importantly, a way to register custom widget areas. This is useful if you want to easily create additional widget areas for particular categories or projects on your site.

To add a new widget area, simply add the name of the widget area to the textbox with each widget area you'd like to register on a new line and then click "Save Options".

Once you have added custom widget areas you can add widgets to them from the Appearance > Widgets menu and then you will be able to select them from the Layout Options > Custom Sidebar dropdown from the post edit page or from the Archive Sidebar dropdown when adding or managing a category, tag or series from the Posts menu.

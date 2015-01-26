Series Landing Pages
====================

Custom landing pages allow you to summarize a :ref:`series of posts <series-tax>` or tie a project together. For one example, see http://inewsnetwork.org/series/hit-and-run: the project page begins with a summary of the series, followed by posts within the series.
Creating a custom landing page is a simple process.

1. Make sure "Custom Landing Pages for Series/Project Pages" is enabled in *Appearance* > *Theme 	Options* > *Advanced*.
2. Create a series
3. Add the series to posts
4. Create the landing page

Creating a series
-----------------

Create a series in **Posts > Series**. Each series should have a name and a slug. If the new series is part of an already-existing series, you can add the parent series from the drop-down. The description is displayed in the standard landing page layout. The sidebar can be chosen from a list of sidebars. If you want, you can create additional sidebars in **Appearance > Theme Options > Layout Options > Sidebar Options**.

Applying a series to a post can be done by selecting the appropriate series from the series list in the post editor. This option can also be used to create a new series.

Creating the landing page
-------------------------

Landing pages are created through the **Landing Pages > Add New** entry in the Dashboard sidebar. Landing pages have the following options:

- Title: The name of the series.
- Display header: If header display is disabled, then the description will not appear.
- Show series byline: If the series is by more than one author, you may want to disable the series byline. The series byline is set at the bottom of the landing page settings page.
- Show social media sharing links: If disabled, social media icons will not appear.
- Layout style
	- Standard: Uses title, description, and featured image. The featured image is set with the page's "Featured Image" settings box.
	- Alternate: Uses title, description, and custom HTML. Checking this option reveals a TinyMCE editor that allows you to write additional content using the standard editor or paste in HTML through the text editor.
- Layout
	- One widget column on the right
	- One widget column on the right and one narrower widget column on the left
	- No widget columns.
	These defaut to those set in :ref:`Theme Options > Advanced Options > Sidebars for Landing Pages <landing-pages-sidebars-option>`, but those values can be overridden.
- Number of posts per page: 10 is the default. Page load times may be negatively affected when choosing "All".
- Post order and 
- Post display options: Affects how the posts are displayed.
	- Show featured image shows the post's featured image
	- Show excerpt shows the post excerpt
	- Show byline shows the post byline
	- Show categories and tags shows each post's categories and tags
- Slug: A short, descriptive label for the page composed of the letters a-z and numbers 0-9, 
- Author: The author of the series. This defaults to the person who created the series, and can be hidden by unchecking the "Show Series Byline" option above.
- Footer layout style
	- None: The series page does not have a custom footer.
	- Use widget: Creates a new "Series Name: Bottom" :doc:`widget area <sidebarswidgets>`, editable in **Appearance > Widgets**
	- Custom HTML: Checking this option reveals a TinyMCE editor that allows you to write additional content using the standard editor or paste in HTML through the text editor.


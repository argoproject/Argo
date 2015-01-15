Theme Options
==============================

When you first activate the Largo theme, there are a number options that need to be configured before you make the site live. The majority of these can be found in the **Appearance** > **Theme Options** menu which you can access from the left sidebar of the WordPress administration interface.

The Theme Options page is organized into three sections which you can access by clicking on the relevant tab across the top of the page: Basic Settings, Theme Images and Homepage Options.

Basic Settings
--------------

**Site Description** - This is a short description of your site that is used in a sidebar or footer widget. Ideally this should just be a short paragraph (1-2 sentences in length) and you can include HTML in this box to link to the "About" page of your site so that visitors can read more about your organization.

**Feed URL** - This is a link to the main RSS feed for your site. By default this will be http://yoursite.com/feed but if you use a feed management and/or analytics tool (such as Feedburner), you can replace the default link here and it will be used in all relevant places on your Largo site.

**Donate Button** - The Largo theme includes an optional donate button in the top header. To enable the donate button, make sure the checkbox to show the donate button is checked and then add the link to your donation page, form or external payment processor here. Optionally, you can change the text of the button. The Largo theme also includes a sidebar widget that you can use to link to a donation page in addition to or instead of the link in the top header.

**Don't Miss Menu** - Under the main navbar on your Largo site is an optional secondary navigation menu that, by default, is called "Don't Miss". To enable this menu make sure the checkbox to show the Don't Miss Menu is checked. Optionally, you can customize the label that appears at the beginning of the menu or remove it entirely. To add or remove links from this menu visit Appearance > Menus from the left sidebar in the WordPress administration interface.

**Footer Nav Menu** - On the left side of the site footer is a configurable menu area. By default the label for this menu will be your site name, but you can change it here. As with the Don't Miss menu area, to add or remove links from this menu visit Appearance > Menus from the left sidebar in the WordPress administration interface.

**Copyright Message** - By default this will display "Copyright [YEAR], Your Site Name" but you can enter your own message here if you would like. You can include HTML in this area to link to external sites and use &copy; to display a copyright symbol or %d to display the current year.

**Google Analytics** - The Largo theme has built in support for Google Analytics. Enter your Google Analytics ID here and the relevant Google Analytics code will be automatically added to all of the pages on your site. Note that it is configured to not track logged in users to ensure accurate reporting.

**Social Media Links** - These are links to relevant social media profiles for your site or organization. These are used in a sidebar widget to provide links to like or follow your organization on Facebook and Twitter, in bylines to attribute content to your organization and in special code in the header to make sure your content appears optimally when shared by other users on these social networks. Be careful to note the recommended format for each link type for maximum compatibility. Note that authors can add links to their own social media profiles by editing their user profile.

**Single Post Options** - By default a box showing an author's bio and social media links (if they have filled out their user profile) and a box showing related content will be shown at the bottom of single article pages. You can choose to hide either of these if you prefer.

Theme Images
------------

This section allows you to upload images that are used primarily in the top header of your Largo site. To add your images:

- Make sure you have created all four image sizes as outlined in our pre-launch checklist and then click "upload" by the image you want to add.

- Drag and drop the image onto the uploader (or click "Select Files" and find the correct image on your computer). When the image has finished uploading, make sure you have selected the full size image and then click the button at the bottom of the uploader that says "Use This Image".

- If the image has uploaded correctly, you should see a thumbnail version of it and the link to the photo in the field next to the "upload" button.

- Once you have uploaded all four images, be sure to click "Save Options" to save your changes.

There is one additional option in this section, a checkbox that allows you to use text in the place of the banner images. It is unlikely that you will use this option, but if you do, selecting this checkbox will use the Site Title and Description from your **Settings** > **General** menu in the place of the the header images so make sure that you have set those options before you enable this feature.

Homepage Options
---------------|

The third and final tab on the Theme Options page is for setting the template you would like to use for your site's homepage. You have two options that you can select by clicking on the relevant preview image and then clicking "Save Options" at the bottom of the page:

**A blog style layout** - This displays your most recent posts in reverse chronological order (newest at the top) with the ability to make a post "sticky" so it stays at the top of the homepage.

**A more traditional newspaper style layout** - If you select this layout you will want to ensure that you are adding featuring images and excerpts for all of your posts and that you have at least six posts at all times set to "Homepage Featured" in the Post Prominence taxonomy (more on the Largo custom taxonomies here) and at least one post (that MUST have a featured image set) marked as the "Top Story", also in the Post Prominence taxonomy.

from Jira
The Largo theme offers seven homepage templates:

- **Blog**: A blog-like list of posts with the ability to stick a post to the top of the homepage. Be sure to set Homepage Bottom to the single column view.
- **Hero with Featured**: Prominently features the top story along with three other 'Featured on Homepage' items, or by itself if none are specified. Best with Homepage Bottom set to 'blank'
- **Hero on the side with Series**: Prominently features the top story along with other posts in its series along the right side
- **Hero with Series**: Prominently features the top story along with other posts in its series, or by itself if not in a series. Best with Homepage Bottom set to 'blank'
- **Single**: Prominently features the top story by itself
- **Slider**: An animated carousel of featured stories with large images. Not recommended but available for backward compatibility.
- **Top Stories**: A newspaper-like layout highlighting one Top Story on the left and others to the right. A popular layout choice!

**Sticky posts**
If you would like posts set as sticky to appear in the sticky box on the homepage, check the "Show sticky posts on homepage?" box. If checked, you will need to set at least one post as sticky for this box to appear. Set a post as sticky by giving it the tag 'sticky' in the post editor.

[[tag-sticky.gif]]

**Homepage bottom templates**
Largo supports three options for the bottom of the homepage:
- A single-column list of recent posts with photos and excerpts
- A two-column widget area: This creates a new widget area in *Appearance* > *Widgets*
- Nothing whatsoever

Homepage display options
- Display options for categories and tags on posts on the homepage
- A single category or tag above the headline for each story
- A list of tags below the story's excerpt
- No tags or categories

- Number of posts to display in the main posts area on the homepage
= Categories to include or exclude from the main posts area on the home page. Enter a comma-separated list of category names or ids:

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
- Set the default region in the left-hand column of landing pages
- Set the default region in the right-hand column of landing pages
- Replace WordPress search with `Google Custom Search <https://support.google.com/customsearch/answer/2630963?hl=en&ctx=topic`_. This is highly recommended.

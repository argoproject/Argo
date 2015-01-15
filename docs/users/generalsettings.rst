General Settings
================

Before you get started with the Largo-specific documentation, 
`the Wordpress documentation <http://codex.wordpress.org/First_Steps_With_WordPress>`_. It will answer many of your questions about setting up your site, writing posts, uploading photos, and creating users.

**General Settings**
This is where you set your site name, tagline, address, general admin user address, time format, and member permissions. Your site description is set in *Appearance* > *Theme Options* > *Basic Settings*.

**Writing**
The most important settings here are the Default Post Category and Default Post Format. You should consider setting the default category to something other than *Uncategorized*. The Default Post Format is ignored in favor of [[Largo post templates]].

**Reading**
These settings are almost entirely overridden by the settings in *Appearance* > *Theme Options* >. The only setting that is not overridden controls whether or not search engines will be discouraged from reading your site and displaying it in search results. Enabling the discouraging feature inserts ``<meta name="robots" content="noindex,follow">`` into your site's ``<head>``. This 
`does not guarantee <http://www.robotstxt.org/meta.html>`_ that your site will not be indexed, and you should include a 
`robots.txt <http://www.robotstxt.org/robotstxt.html>`_ on your site for additional discouragement.

**Discussion**
The settings found in Settings > Discussion control commenting, comment moderation, commenter avatars, and 
`pingbacks <http://codex.wordpress.org/Introduction_to_Blogging#Pingbacks>`_. For a more in-depth discussion, see the 
`WP Codex entry on this screen <http://codex.wordpress.org/Settings_Discussion_Screen>`_ .

If you want anyone to be able to sign up to comment, that setting is in Settings > General Settings.

**Media**
The media settings in Settings > Media allow you to control the sizes that images get resized to upon uploads, and if uploaded files are kept in a pool or in folders organized by year and month.

**Permalinks**
Permalinks are the permanent URLs to your individual weblog posts, as well as categories and other lists of weblog postings. Readers and other sites will use these links to link to your articles, so you should pick a permalink format once and never change it.
Some default options are included in WordPress, or you can create a custom structure. Change the setting in Settings > Permalinks.
For more information about permalinks, see the 
`WP Codx entry on permalinks <http://codex.wordpress.org/Using_Permalinks>`_

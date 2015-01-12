Download and Install Wordpress
==============================


The Largo parent theme and plugins have been tested with the latest version of WordPress. Some hosting providers offer one-click installation of WordPress and that should get you the latest version. If that does not work for you, download the latest version from the `WordPress downloads <https://wordpress.org/download/>`_  page and follow their `instructions <http://codex.wordpress.org/Installing_WordPress>`_ to get it setup.

**Download the Largo parent theme**

The latest stable version of the Largo parent theme is `available for download <https://github.com/INN/Largo>`_  on github. Just click on the button labeled "zip" near the top of the repository page to download a .zip file of the latest version. You will then want to unzip it, rename the folder to something a little cleaner (preferably just "largo") and then upload it to your hosting provider in the /wp-content/themes/ folder of your WordPress installation.

**Create a child theme and activate it**

In order to make it easier to upgrade to future versions of the Largo parent theme, you will want to add any customizations that are unique to your organization by creating a child theme. WordPress has a `tutorial you can follow <http://codex.wordpress.org/Child_Themes>`_ that explains how to create and configure a child theme.

At a minimum you will need to create a new theme folder (call it something like "largo-child" in your wp-content/themes directory and add one file to it called style.css. That file would be used to add any custom CSS unique to your child theme, but it also tells WordPress where to find the parent theme.

At the very top of the file you need to add at least the following:
	
.. code::

    /*
    Theme Name:     Your Child Theme's Name
    Theme URI:      Your Site URL
    Description:    Your Theme Description
    Author:         Your Name
    Author URI:     Author URL
    Template:       largo
    Version:        0.1.0
    */

    @import url("../largo/style.css");	


The line starting with "Template" must include the name of the parent theme (this should be "largo" unless you rename it) and the line starting with @import must include the path to the stylesheet for the Largo parent theme's stylesheet (in most cases it will be as shown above).

If you would prefer, we have created an example of a simple child theme that you can start from.

Download it here: `Largo Child Theme <http://largoproject.wpengine.netdna-cdn.com/wp-content/uploads/2012/08/largo-child.zip>`_
 (ZIP file, right click to download).

Simply unzip this file and upload the folder to your wp-content/themes directory along with the Largo parent theme.

Now that you have a child theme created, login to your WordPress site and in the left sidebar click on "Appearance" and then "Themes". Find your child theme, click activate and then you should see your new child theme in action on your site and can begin customizing.

**Configure theme options**

Now that you have activated your theme you will want to configure some of the built-in options that come with Largo. You can find these in the Appearance > Theme Options menu.

There are three tabs across the top of the page that allow you to access different sections of the Theme Options.

Basic Settings Theeme Settings Homepage Options

The **Basic Settings** tab allows you to enter some basic information about your site such as a short description and social media links and to enable/disable and configure some of the built-in functionality in the Largo theme such as related content at the bottom of single articles and a number of menu areas that you will configure in the next step.

The **Theme Images** tab is where you will upload a number of images that the Largo theme requires. These include a thumbnail-sized logo image and three banner images that are used as the site's top banner on different screen sizes.

And finally, the **Homepage Options** tab allows you to choose between different homepage layouts. The first (and default) setting is a reverse chronological blog style layout and a more newspaper-style layout.  Do these have names?

For more on Theme Options and an explanation of what each of them does, please visit our Theme Options documentation page.

**Configure menus and sidebars**

Once you setup your theme options, you will likely want to configure the menu areas on your site and possibly configure the content of the default sidebars that are included as part of the Largo parent theme.

These are configured from the **Appearance** > **Menus** and **Appearance** > **Widgets** menus, respectively and we have complete documentation for how these are implemented in the Largo parent theme on our Menus and Sidebars and Widgets documentation pages.

**Install required/recommended plugins**

The Largo parent theme comes packaged with a number of plugins developed by NPR as part of their Project Argo and some additional recommended plugins that add various functionality to your Largo site. We have a complete list of these plugins and what they are used for on our plugins page.

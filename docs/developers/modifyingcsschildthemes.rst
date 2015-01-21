Modifying CSS and Using Child Themes
====================================

Changing Basic Styling
----------------------

Largo has a built-in way to change some basic styling options.
   
To enable this option, from the *Appearance* > *Theme Options* screen click on the "Advanced" tab and check the box labelled "Enable Custom LESS to CSS For Theme Customization" and then save the settings.
 
You will now see an additional menu item under the Appearance menu labelled "CSS Variables". From this menu you will be able to change some basic styling attributes of your Largo site, including the color scheme, fonts and font-sizes.
   
This option is only intended for making some basic changes to your site's styles. For anything more complex you will need to create a child theme.

Child theme
-----------
 
More advanced customization is possible by creating a WordPress 
`child theme <http://codex.wordpress.org/Child_Themes>`_ to override Largo default styles using custom CSS in the child theme's style.css file.
 
This is the preferred way to make style changes to Largo. Do not change the styles in the Largo parent theme directly or else you risk losing your changes should you decide to update to a new version of Largo in the future.

For Largo itself and many of the child themes the INN team develops 
`LESS <http://lesscss.org/>`_ is our preferred CSS pre-processor.
 
The typical folder structure of our themes (assuming Largo + a child theme) looks like:
 
`` wp-content/themes ``

`` - /largo``

``  -- /less ``

``   --- style.less (@imports all the other less files from the /inc folder)``

``   --- /inc (all the other less files that get compiled down into style.css)``

``   - /largo-child``

``   -- /less``

``   --- style.less (typically contains the normal WP header block, variable declarations and any @import-ed other less files found in this folder)``

``   --- other.less (optionally, one or more other less files that get pulled into the``

``   --- ...``

``   -- style.css (the target file /less/style.less compiles down into) ``

 

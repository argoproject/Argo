For Developers
===============
Project Largo is released as open source software under the `GNU General version 2 <http://www.gnu.org/licenses/gpl-2.0.html>`_ and you are welcome to `download or fork the project from our github repository <https://github.com/INN/Largo>`_.

If you encounter any bugs or add additional functionality, please drop us a note and let us know or `submit a pull request <https://github.com/INN/Largo/compare/argoproject:master...master>`_ and we will try to incorporate your work into our next release.

A few brief technical notes that might be helpful as you hack away:

-When you download the theme you'll notice that the /inc folder contains most of the add-on functionality for the parent theme and all of these files are then included via functions.php

-Most of our custom functions (at least the ones we thought might be relevant) are pluggable so you can write your own version of them by using the same function name in a child theme's functions.php. You can read up on how that works in the `WordPress codex section about child themes <http://codex.wordpress.org/Child_Themes>`_.

The theme uses the Options Framework for the theme options pages so if you need to access a value from the database, you will need to use ``f_get_option()`` instead of the usual ``get_option()``. The theme options pages themselves can be customized from options.php in the main theme folder.

The Largo parent theme uses `LESS CSS <http://lesscss.org/>`_ to generate the stylesheets including a number of elements borrowed and tweaked from `Twitter Bootstrap <http://getbootstrap.com/2.3.2/>`_. You will notice that the theme's main style.css imports /css/style.css which is the output of /less/style.less when it's compiled. A future version of the Largo framework will allow end users to customize the theme by changing theme options instead of having to delve into the code (likely using 
`lessphp <https://github.com/leafo/lessphp>`_ to modify variables.less and recompiling when the theme options are saved) but since none of that is currently implemented, your best bet will be to modify the LESS files and recompile or create a child theme and selectively override the default styles.

We also use `TGM Plugin Activation <https://github.com/thomasgriffin/TGM-Plugin-Activation>`_ to package a couple of plugins with the Largo theme that are not currently available in the WordPress plugin directory and to recommend plugins for a number of tasks that are commonly requested for news websites. You can change the list of recommended plugins by modifying /inc/largo-plugin-init.php.

The rest of the theme files should be familiar to most WordPress developers, but if you have any questions, feel free to get in touch or submit a question in our Q&A section and we'll try to help you out.
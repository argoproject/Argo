For Developers
==============

Overview
--------

Project Largo is released as open source software and anyone is welcome to `download or fork the project from our github repository <https://github.com/INN/Largo>`_ and use it as they like.

If use Largo for a project `we'd love to hear from you <mailto:largo@inn.org>`_ so can we add you to our list of sites using Largo and help get the word out.

The preferred way of building a site with Largo is by creating a WordPress child theme. We have created a `sample, heavily documented, child theme <https://github.com/INN/Largo-Sample-Child-Theme/archive/master.zip>`_ to help you understand the way we structure our child themes in the hopes that it will give you a solid framework to get started. There is more information on setting up Largo and using child themes in the download and installation section of our documentation.


Technical Notes
---------------

A few brief technical notes that might be helpful as you get started:

- When you download the theme you'll notice that the /inc folder contains most of the add-on functionality for the parent theme and all of these files are then loaded up via functions.php

- Most of our custom functions (at least the ones we thought might be relevant) are pluggable so you can write your own version of them by using the same function name in a child theme's functions.php. You can read up on how that works in the `WordPress codex section about child themes <http://codex.wordpress.org/Child_Themes>`_.

- The theme uses the Options Framework for the theme options pages so if you need to access a value from the database, you will need to use ``of_get_option()`` instead of the usual ``get_option()``. The theme options pages themselves can be customized from options.php in the main theme folder.

- The Largo parent theme uses `LESS CSS <http://lesscss.org/>`_ to generate the stylesheets including a number of elements borrowed and tweaked from `Twitter Bootstrap <http://getbootstrap.com/2.3.2/>`_. You will notice that the theme's main style.css is empty except for the header block because we enqueue our styles from /css/style.css (the output of /less/style.less when it's compiled).

- We use `TGM Plugin Activation <https://github.com/thomasgriffin/TGM-Plugin-Activation>`_ to package a couple of plugins with the Largo theme that are not currently available in the WordPress plugin directory and to recommend plugins for a number of tasks that are commonly requested for news websites.

- The rest of the theme files and the folder structure should be familiar to most WordPress developers, but if you have any questions, feel free to `get in touch<mailto:largo@inn.org>`_.


Function Reference
------------------

We are presently working on a more comprehensive function reference (likely to be released with version 0.5, if not sooner). Stay tuned!


Bug Reports and Feature Requests
--------------------------------

Our preferred way for you to submit bug reports, request for new features or even questions about how things work in Largo is by `opening a new issue on the Largo github repository <https://github.com/INN/Largo/issues>`_.


Contributing to Largo
---------------------

We welcome (and encourage) anyone who wants to contribute back to the project.

To begin, `please review our contribution guidelines <https://github.com/INN/docs/blob/master/how-to-work-with-us/contributing.md>`_.

We have many ways you can contribute and not all are technical. Wherever possible we will flag issues that we believe are `good for beginners <https://github.com/INN/Largo/issues?q=is%3Aopen+is%3Aissue+label%3A%22good+for+beginners%22>`_ or for less/non-technical contributors (`writing/improving documentation <https://github.com/INN/Largo/issues?q=is%3Aopen+is%3Aissue+label%3A%22status%3A+needs+docs%22>`_, etc.).

Our roadmap, open issues, suggested features and discussion can always be found in the issues section of the `Largo github repository <https://github.com/INN/Largo/issues>`_.

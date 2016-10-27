For Developers
==============

Overview
--------

Project Largo is released as open source software and anyone is welcome to `download or fork the project from our github repository <https://github.com/INN/Largo>`_ and use it as they like.

If you use Largo for a project we'd love to hear from you so can we add you to our list of sites using Largo and help get the word out. Send us an email! largo@inn.org

The preferred way of building a site with Largo is by creating a WordPress child theme. We have created a `sample, heavily documented, child theme <childthemes.html#advanced-theme-development-and-modification>`_ to help you understand the way we structure our child themes in the hopes that it will give you a solid framework to get started. There is more information on setting up Largo and `using child themes <../users/download.html#creating-child-themes>`_ in the download and installation section of our documentation.

Setting up a development environment
------------------------------------

We use a set of tools to make setting up a Largo development environment as easy and consistent as possible.

We encourage all INN member organizations looking to add features to or otherwise modify their theme to use this same setup, since doing so will make support and collaboration between members and INN easier.

**Read**:

.. toctree::
    :maxdepth: 2

    setup
    setup-documentation
    intro-command-line

Child Themes
------------

What *is* a child theme?
````````````````````````

From the `WordPress Codex <http://codex.wordpress.org/Child_Themes>`_:

  A child theme is a theme that inherits the functionality and styling of another theme, called the parent theme. Child themes are the recommended way of modifying an existing theme.

Why should you use a child theme?
`````````````````````````````````
In order to make it easier to upgrade to future versions of the Largo parent theme, you will want to add any customizations that are unique to your site by creating a child theme. WordPress has a `tutorial you can follow <http://codex.wordpress.org/Child_Themes>`_ that explains how to create and configure a child theme.

**More:** `Using Child Themes <../developers/childthemes.html>`_.

.. toctree::
    :maxdepth: 2

    childthemes

Custom Post Templates
---------------------

Largo allows you to select between three default templates to use for posts and pages on your site. This default is set from the **Appearance > Theme Options > Layout** tab under the “Single Article Template” heading.

- One Column (Standard Layout) is a new default article template in Largo version 0.4 that focuses on readability, reduces distractions and allows for beautiful presentation of visual elements within a story with a large “hero” section at the top of the article for featured media (photo, video, slideshow or embedded media).
- Two Columns (Classic Layout) is the previous article template from Largo version 0.3 and before which features a content area on the left and a sidebar on the right.
- Full-width (no sidebar) is an option when posts need a wider content area for things like maps and interactive data applications. The full-width template is not ideal for text, as the line length is non-optimal for a good reading experience.


Technical Notes
---------------

A few brief technical notes that might be helpful as you get started:

.. toctree::
    :maxdepth: 2

    technicalnotes
    grunt-commands
    hooksfilters

Function Reference
------------------

NOTE: the function reference is a work-in-progress and may not be very useful at the moment.

It may be helpful to  `read Largo's source on Github <https://github.com/INN/Largo>`_. If you discover insight there that is not included in these docs, please `let us know <#contributing-to-largo>`_.

.. toctree::
    :maxdepth: 2

    /api/index
    constants
    hooksfilters

Bug Reports and Feature Requests
--------------------------------

Our preferred way for you to submit bug reports, requests for new features or even questions about how things work in Largo is by `opening a new issue on the Largo github repository <https://github.com/INN/Largo/issues>`_.

Contributing to Largo
---------------------

We welcome (and encourage) anyone who wants to contribute back to the project.

To begin, `please review our contribution guidelines <https://github.com/INN/docs/blob/master/how-to-work-with-us/contributing.md>`_.

We have many ways you can contribute and not all are technical. Wherever possible we will flag issues that we believe are `good for beginners <https://github.com/INN/Largo/issues?q=is%3Aopen+is%3Aissue+label%3A%22good+for+beginners%22>`_ or for less/non-technical contributors (`writing/improving documentation <https://github.com/INN/Largo/issues?q=is%3Aopen+is%3Aissue+label%3A%22status%3A+needs+docs%22>`_, etc.).

Our roadmap, open issues, suggested features and discussion can always be found in the issues section of the `Largo github repository <https://github.com/INN/Largo/issues>`_.

We also have documentation on the `Anatomy of a Pull Request and Submission Protocol <https://github.com/INN/docs/blob/master/how-to-work-with-us/pull-requests.md>`_ and `Contributing to the INN Nerds docs repo using Github.com <https://github.com/INN/docs/blob/master/how-to-work-with-us/via-github.md>`_ which explain, at a high level, the process of contributing to Github projects, generally.

If you would like to help with the documentation, here are some resources:

- `Sphinx' PHP domain-specific markup <http://mark-story.com/posts/view/sphinx-phpdomain-released>`_
- `Sphinx reStructuredText primer and quickstart guide <http://sphinx-doc.org/rest.html>`_


If you have feedback on this collection of documentation, please `get in touch <../feedback.html>`_.

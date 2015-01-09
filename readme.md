# Project Largo

A responsive WordPress framework developed by the Investigative News Network and specifically designed for news publishers.

---

**IMPORTANT!** THIS PROJECT IS UNDER ACTIVE DEVELOPMENT

We are making regular updates that may or may not always play nice with previous versions.

The `master` branch is the latest stable version and what INN is using for our sites in production (with a few minor tweaks specific to our hosting environment). Please do not submit pull requests to this branch unless they are minor hotfixes that can be directly merged.

The `develop` branch contains work in progress slated for our next point release. Feel free to try it out, report issues, etc. but we DO NOT recommend using it in production. This is also typically the branch to submit pull requests to if you want to contribute to the project.

Feedback, comments and questions to: [largo@investigativenewsnetwork.org](mailto:largo@investigativenewsnetwork.org)

---

## About Project Largo
<img align="right" src="http://i.imgur.com/nXAl3bC.png" />
Project Largo is a responsive WordPress starter/parent theme designed with the needs of news publisers in mind.

The project extends work done by [NPR's Project Argo](http://argoproject.org/).

Documentation and more information at: [largoproject.org](http://largoproject.org)

**VERSION**: 0.4

## Setup

* Download and Install WordPress
* Download the latest version of the Largo parent theme
* Create a child theme and activate from the WordPress appearance menu. If you are not familiar with how child themes work, see: http://codex.wordpress.org/Child_Themes
* Install required/recommended plugins
* Configure your theme options in the Appearance > Theme Options menu
* Configure your menus and sidebars (also in the Appearance menu)

Additionally, you can customize your child theme's CSS by overriding Largo's default styles in the style.css file of your child theme and many of the Largo template functions are "pluggable" so you can write your own versions in the functions.php of your child theme to modify their behavior.

## Credits

Designed and built by Adam Schweigert ([@aschweig](http://twitter.com/aschweig)) for the Investigative News Network ([@INN](http://twitter.com/INN)).

Additional assistance from Ben Byrne and Seamus Leahy of [Cornershop Creative](http://cornershopcreative.com).

* Investigative News Network: [investigativenewsnetwork.org](http://investigativenewsnetwork.org)

This project builds on a number of great open source projects, including:

* Project Argo: [argoproject.org](http://argoproject.org/)
* Twitter Bootstrap: [getbootstrap.com](http://getbootstrap.com/)
* LESS CSS: [lesscss.org](http://lesscss.org/)
* Options Framework: [devinsays/options-framework-theme](https://github.com/devinsays/options-framework-theme)
* TGM Plugin Activation Library: [thomasgriffin/TGM-Plugin-Activation](https://github.com/thomasgriffin/TGM-Plugin-Activation)
# Makefile for Sphinx documentation
#

# You can set these variables from the command line.
SPHINXOPTS    =
SPHINXBUILD   = sphinx-build
PAPER         =
BUILDDIR      = _build

# User-friendly check for sphinx-build
ifeq ($(shell which $(SPHINXBUILD) >/dev/null 2>&1; echo $$?), 1)
$(error The '$(SPHINXBUILD)' command was not found. Make sure you have Sphinx installed, then set the SPHINXBUILD environment variable to point to the full path of the '$(SPHINXBUILD)' executable. Alternatively you can add the directory with the executable to your PATH. If you don't have Sphinx installed, grab it from http://sphinx-doc.org/)
endif

# Internal variables.
PAPEROPT_a4     = -D latex_paper_size=a4
PAPEROPT_letter = -D latex_paper_size=letter
ALLSPHINXOPTS   = -d $(BUILDDIR)/doctrees $(PAPEROPT_$(PAPER)) $(SPHINXOPTS) .
# the i18n builder cannot share the environment and doctrees with the others
I18NSPHINXOPTS  = $(PAPEROPT_$(PAPER)) $(SPHINXOPTS) .

.PHONY: help clean html dirhtml singlehtml pickle json htmlhelp qthelp devhelp epub latex latexpdf text man changes linkcheck doctest gettext

help:
	@echo "Please use \`make <target>' where <target> is one of"
	@echo "  html       to make standalone HTML files"
	@echo "  dirhtml    to make HTML files named index.html in directories"
	@echo "  singlehtml to make a single large HTML file"
	@echo "  pickle     to make pickle files"
	@echo "  json       to make JSON files"
	@echo "  htmlhelp   to make HTML files and a HTML help project"
	@echo "  qthelp     to make HTML files and a qthelp project"
	@echo "  devhelp    to make HTML files and a Devhelp project"
	@echo "  epub       to make an epub"
	@echo "  latex      to make LaTeX files, you can set PAPER=a4 or PAPER=letter"
	@echo "  latexpdf   to make LaTeX files and run them through pdflatex"
	@echo "  latexpdfja to make LaTeX files and run them through platex/dvipdfmx"
	@echo "  text       to make text files"
	@echo "  man        to make manual pages"
	@echo "  texinfo    to make Texinfo files"
	@echo "  info       to make Texinfo files and run them through makeinfo"
	@echo "  gettext    to make PO message catalogs"
	@echo "  changes    to make an overview of all changed/added/deprecated items"
	@echo "  xml        to make Docutils-native XML files"
	@echo "  pseudoxml  to make pseudoxml-XML files for display purposes"
	@echo "  linkcheck  to check all external links for integrity"
	@echo "  doctest    to run all doctests embedded in the documentation (if enabled)"

clean:
	rm -rf $(BUILDDIR)/*

html:
	$(SPHINXBUILD) -b html $(ALLSPHINXOPTS) $(BUILDDIR)/html
	@echo
	@echo "Build finished. The HTML pages are in $(BUILDDIR)/html."

dirhtml:
	$(SPHINXBUILD) -b dirhtml $(ALLSPHINXOPTS) $(BUILDDIR)/dirhtml
	@echo
	@echo "Build finished. The HTML pages are in $(BUILDDIR)/dirhtml."

singlehtml:
	$(SPHINXBUILD) -b singlehtml $(ALLSPHINXOPTS) $(BUILDDIR)/singlehtml
	@echo
	@echo "Build finished. The HTML page is in $(BUILDDIR)/singlehtml."

pickle:
	$(SPHINXBUILD) -b pickle $(ALLSPHINXOPTS) $(BUILDDIR)/pickle
	@echo
	@echo "Build finished; now you can process the pickle files."

json:
	$(SPHINXBUILD) -b json $(ALLSPHINXOPTS) $(BUILDDIR)/json
	@echo
	@echo "Build finished; now you can process the JSON files."

htmlhelp:
	$(SPHINXBUILD) -b htmlhelp $(ALLSPHINXOPTS) $(BUILDDIR)/htmlhelp
	@echo
	@echo "Build finished; now you can run HTML Help Workshop with the" \
	      ".hhp project file in $(BUILDDIR)/htmlhelp."

qthelp:
	$(SPHINXBUILD) -b qthelp $(ALLSPHINXOPTS) $(BUILDDIR)/qthelp
	@echo
	@echo "Build finished; now you can run "qcollectiongenerator" with the" \
	      ".qhcp project file in $(BUILDDIR)/qthelp, like this:"
	@echo "# qcollectiongenerator $(BUILDDIR)/qthelp/LargoProject.qhcp"
	@echo "To view the help file:"
	@echo "# assistant -collectionFile $(BUILDDIR)/qthelp/LargoProject.qhc"

devhelp:
	$(SPHINXBUILD) -b devhelp $(ALLSPHINXOPTS) $(BUILDDIR)/devhelp
	@echo
	@echo "Build finished."
	@echo "To view the help file:"
	@echo "# mkdir -p $$HOME/.local/share/devhelp/LargoProject"
	@echo "# ln -s $(BUILDDIR)/devhelp $$HOME/.local/share/devhelp/LargoProject"
	@echo "# devhelp"

epub:
	$(SPHINXBUILD) -b epub $(ALLSPHINXOPTS) $(BUILDDIR)/epub
	@echo
	@echo "Build finished. The epub file is in $(BUILDDIR)/epub."

latex:
	$(SPHINXBUILD) -b latex $(ALLSPHINXOPTS) $(BUILDDIR)/latex
	@echo
	@echo "Build finished; the LaTeX files are in $(BUILDDIR)/latex."
	@echo "Run \`make' in that directory to run these through (pdf)latex" \
	      "(use \`make latexpdf' here to do that automatically)."

latexpdf:
	$(SPHINXBUILD) -b latex $(ALLSPHINXOPTS) $(BUILDDIR)/latex
	@echo "Running LaTeX files through pdflatex..."
	$(MAKE) -C $(BUILDDIR)/latex all-pdf
	@echo "pdflatex finished; the PDF files are in $(BUILDDIR)/latex."

latexpdfja:
	$(SPHINXBUILD) -b latex $(ALLSPHINXOPTS) $(BUILDDIR)/latex
	@echo "Running LaTeX files through platex and dvipdfmx..."
	$(MAKE) -C $(BUILDDIR)/latex all-pdf-ja
	@echo "pdflatex finished; the PDF files are in $(BUILDDIR)/latex."

text:
	$(SPHINXBUILD) -b text $(ALLSPHINXOPTS) $(BUILDDIR)/text
	@echo
	@echo "Build finished. The text files are in $(BUILDDIR)/text."

man:
	$(SPHINXBUILD) -b man $(ALLSPHINXOPTS) $(BUILDDIR)/man
	@echo
	@echo "Build finished. The manual pages are in $(BUILDDIR)/man."

texinfo:
	$(SPHINXBUILD) -b texinfo $(ALLSPHINXOPTS) $(BUILDDIR)/texinfo
	@echo
	@echo "Build finished. The Texinfo files are in $(BUILDDIR)/texinfo."
	@echo "Run \`make' in that directory to run these through makeinfo" \
	      "(use \`make info' here to do that automatically)."

info:
	$(SPHINXBUILD) -b texinfo $(ALLSPHINXOPTS) $(BUILDDIR)/texinfo
	@echo "Running Texinfo files through makeinfo..."
	make -C $(BUILDDIR)/texinfo info
	@echo "makeinfo finished; the Info files are in $(BUILDDIR)/texinfo."

gettext:
	$(SPHINXBUILD) -b gettext $(I18NSPHINXOPTS) $(BUILDDIR)/locale
	@echo
	@echo "Build finished. The message catalogs are in $(BUILDDIR)/locale."

changes:
	$(SPHINXBUILD) -b changes $(ALLSPHINXOPTS) $(BUILDDIR)/changes
	@echo
	@echo "The overview file is in $(BUILDDIR)/changes."

linkcheck:
	$(SPHINXBUILD) -b linkcheck $(ALLSPHINXOPTS) $(BUILDDIR)/linkcheck
	@echo
	@echo "Link check complete; look for any errors in the above output " \
	      "or in $(BUILDDIR)/linkcheck/output.txt."

doctest:
	$(SPHINXBUILD) -b doctest $(ALLSPHINXOPTS) $(BUILDDIR)/doctest
	@echo "Testing of doctests in the sources finished, look at the " \
	      "results in $(BUILDDIR)/doctest/output.txt."

xml:
	$(SPHINXBUILD) -b xml $(ALLSPHINXOPTS) $(BUILDDIR)/xml
	@echo
	@echo "Build finished. The XML files are in $(BUILDDIR)/xml."

pseudoxml:
	$(SPHINXBUILD) -b pseudoxml $(ALLSPHINXOPTS) $(BUILDDIR)/pseudoxml
	@echo
	@echo "Build finished. The pseudo-XML files are in $(BUILDDIR)/pseudoxml."

php:
	@echo "Building .rst files"
	@echo "functions.php"
	doxphp < ../404.php | doxphp2sphinx > api/404.rst
	doxphp < ../archive.php | doxphp2sphinx > api/archive.rst
	doxphp < ../category.php | doxphp2sphinx > api/category.rst
	doxphp < ../comments.php | doxphp2sphinx > api/comments.rst
	doxphp < ../feed-mailchimp.php | doxphp2sphinx > api/feed-mailchimp.rst
	doxphp < ../footer.php | doxphp2sphinx > api/footer.rst
	doxphp < ../full-page.php | doxphp2sphinx > api/full-page.rst
	doxphp < ../functions.php | doxphp2sphinx > api/functions.rst
	doxphp < ../header.php | doxphp2sphinx > api/header.rst
	doxphp < ../home.php | doxphp2sphinx > api/home.rst
	doxphp < ../homepages/homepage-class.php | doxphp2sphinx > api/homepages/homepage-class.rst
	doxphp < ../homepages/homepage.php | doxphp2sphinx > api/homepages/homepage.rst
	doxphp < ../homepages/layouts/HomepageBlog.php | doxphp2sphinx > api/homepages/layouts/HomepageBlog.rst
	doxphp < ../homepages/layouts/HomepageSingle.php | doxphp2sphinx > api/homepages/layouts/HomepageSingle.rst
	doxphp < ../homepages/layouts/HomepageSingleWithFeatured.php | doxphp2sphinx > api/homepages/layouts/HomepageSingleWithFeatured.rst
	doxphp < ../homepages/layouts/HomepageSingleWithSeriesStories.php | doxphp2sphinx > api/homepages/layouts/HomepageSingleWithSeriesStories.rst
	doxphp < ../homepages/layouts/LegacyThreeColumn.php | doxphp2sphinx > api/homepages/layouts/LegacyThreeColumn.rst
	doxphp < ../homepages/layouts/TopStories.php | doxphp2sphinx > api/homepages/layouts/TopStories.rst
	doxphp < ../homepages/templates/blog.php | doxphp2sphinx > api/homepages/templates/blog.rst
	doxphp < ../homepages/templates/full-width-image.php | doxphp2sphinx > api/homepages/templates/full-width-image.rst
	doxphp < ../homepages/templates/legacy-three-column.php | doxphp2sphinx > api/homepages/templates/legacy-three-column.rst
	doxphp < ../homepages/templates/top-stories.php | doxphp2sphinx > api/homepages/templates/top-stories.rst
	doxphp < ../homepages/zones/zones.php | doxphp2sphinx > api/homepages/zones/zones.rst
	doxphp < ../image.php | doxphp2sphinx > api/image.rst
	doxphp < ../inc/ad-codes.php | doxphp2sphinx > api/inc/ad-codes.rst
	doxphp < ../inc/ajax-functions.php | doxphp2sphinx > api/inc/ajax-functions.rst
	doxphp < ../inc/avatars/admin.php | doxphp2sphinx > api/inc/avatars/admin.rst
	doxphp < ../inc/avatars/functions.php | doxphp2sphinx > api/inc/avatars/functions.rst
	doxphp < ../inc/avatars.php | doxphp2sphinx > api/inc/avatars.rst
	doxphp < ../inc/custom-feeds.php | doxphp2sphinx > api/inc/custom-feeds.rst
	doxphp < ../inc/custom-less-variables.php | doxphp2sphinx > api/inc/custom-less-variables.rst
	doxphp < ../inc/customizer/class-largo-wp-customize-multi-checkbox-control.php | doxphp2sphinx > api/inc/customizer/class-largo-wp-customize-multi-checkbox-control.rst
	doxphp < ../inc/customizer/class-largo-wp-customize-rich-radio-control.php | doxphp2sphinx > api/inc/customizer/class-largo-wp-customize-rich-radio-control.rst
	doxphp < ../inc/customizer/class-largo-wp-customize-textarea-control.php | doxphp2sphinx > api/inc/customizer/class-largo-wp-customize-textarea-control.rst
	doxphp < ../inc/customizer/customizer.php | doxphp2sphinx > api/inc/customizer/customizer.rst
	doxphp < ../inc/dashboard.php | doxphp2sphinx > api/inc/dashboard.rst
	doxphp < ../inc/deprecated.php | doxphp2sphinx > api/inc/deprecated.rst
	doxphp < ../inc/editor.php | doxphp2sphinx > api/inc/editor.rst
	doxphp < ../inc/enqueue.php | doxphp2sphinx > api/inc/enqueue.rst
	doxphp < ../inc/featured-content.php | doxphp2sphinx > api/inc/featured-content.rst
	doxphp < ../inc/featured-media.php | doxphp2sphinx > api/inc/featured-media.rst
	doxphp < ../inc/header-footer.php | doxphp2sphinx > api/inc/header-footer.rst
	doxphp < ../inc/helpers.php | doxphp2sphinx > api/inc/helpers.rst
	doxphp < ../inc/home-templates.php | doxphp2sphinx > api/inc/home-templates.rst
	doxphp < ../inc/images.php | doxphp2sphinx > api/inc/images.rst
	doxphp < ../inc/metabox-api.php | doxphp2sphinx > api/inc/metabox-api.rst
	doxphp < ../inc/nav-menus.php | doxphp2sphinx > api/inc/nav-menus.rst
	doxphp < ../inc/open-graph.php | doxphp2sphinx > api/inc/open-graph.rst
	doxphp < ../inc/picturefill/inc/class-model-picturefill-wp.php | doxphp2sphinx > api/inc/picturefill/inc/class-model-picturefill-wp.rst
	doxphp < ../inc/picturefill/inc/class-picturefill-wp.php | doxphp2sphinx > api/inc/picturefill/inc/class-picturefill-wp.rst
	doxphp < ../inc/picturefill/inc/class-view-picturefill-wp.php | doxphp2sphinx > api/inc/picturefill/inc/class-view-picturefill-wp.rst
	doxphp < ../inc/picturefill/inc/templates/fallback-source-template.php | doxphp2sphinx > api/inc/picturefill/inc/templates/fallback-source-template.rst
	doxphp < ../inc/picturefill/inc/templates/noscript-template.php | doxphp2sphinx > api/inc/picturefill/inc/templates/noscript-template.rst
	doxphp < ../inc/picturefill/inc/templates/picture-template.php | doxphp2sphinx > api/inc/picturefill/inc/templates/picture-template.rst
	doxphp < ../inc/picturefill/inc/templates/source-template.php | doxphp2sphinx > api/inc/picturefill/inc/templates/source-template.rst
	doxphp < ../inc/picturefill/picturefill-wp.php | doxphp2sphinx > api/inc/picturefill/picturefill-wp.rst
	doxphp < ../inc/plugin-init.php | doxphp2sphinx > api/inc/plugin-init.rst
	doxphp < ../inc/post-metaboxes.php | doxphp2sphinx > api/inc/post-metaboxes.rst
	doxphp < ../inc/post-tags.php | doxphp2sphinx > api/inc/post-tags.rst
	doxphp < ../inc/post-templates.php | doxphp2sphinx > api/inc/post-templates.rst
	doxphp < ../inc/related-content.php | doxphp2sphinx > api/inc/related-content.rst
	doxphp < ../inc/sidebars.php | doxphp2sphinx > api/inc/sidebars.rst
	doxphp < ../inc/taxonomies.php | doxphp2sphinx > api/inc/taxonomies.rst
	doxphp < ../inc/term-icons.php | doxphp2sphinx > api/inc/term-icons.rst
	doxphp < ../inc/term-meta.php | doxphp2sphinx > api/inc/term-meta.rst
	doxphp < ../inc/term-sidebars.php | doxphp2sphinx > api/inc/term-sidebars.rst
	doxphp < ../inc/update.php | doxphp2sphinx > api/inc/update.rst
	doxphp < ../inc/users.php | doxphp2sphinx > api/inc/users.rst
	doxphp < ../inc/verify.php | doxphp2sphinx > api/inc/verify.rst
	doxphp < ../inc/widgets/largo-about.php | doxphp2sphinx > api/inc/widgets/largo-about.rst
	doxphp < ../inc/widgets/largo-author-bio.php | doxphp2sphinx > api/inc/widgets/largo-author-bio.rst
	doxphp < ../inc/widgets/largo-disclaimer-widget.php | doxphp2sphinx > api/inc/widgets/largo-disclaimer-widget.rst
	doxphp < ../inc/widgets/largo-donate.php | doxphp2sphinx > api/inc/widgets/largo-donate.rst
	doxphp < ../inc/widgets/largo-explore-related.php | doxphp2sphinx > api/inc/widgets/largo-explore-related.rst
	doxphp < ../inc/widgets/largo-facebook.php | doxphp2sphinx > api/inc/widgets/largo-facebook.rst
	doxphp < ../inc/widgets/largo-featured.php | doxphp2sphinx > api/inc/widgets/largo-featured.rst
	doxphp < ../inc/widgets/largo-follow.php | doxphp2sphinx > api/inc/widgets/largo-follow.rst
	doxphp < ../inc/widgets/largo-footer-featured.php | doxphp2sphinx > api/inc/widgets/largo-footer-featured.rst
	doxphp < ../inc/widgets/largo-image-widget.php | doxphp2sphinx > api/inc/widgets/largo-image-widget.rst
	doxphp < ../inc/widgets/largo-inn-rss.php | doxphp2sphinx > api/inc/widgets/largo-inn-rss.rst
	doxphp < ../inc/widgets/largo-post-series-links.php | doxphp2sphinx > api/inc/widgets/largo-post-series-links.rst
	doxphp < ../inc/widgets/largo-prev-next-post-links.php | doxphp2sphinx > api/inc/widgets/largo-prev-next-post-links.rst
	doxphp < ../inc/widgets/largo-recent-comments.php | doxphp2sphinx > api/inc/widgets/largo-recent-comments.rst
	doxphp < ../inc/widgets/largo-recent-posts.php | doxphp2sphinx > api/inc/widgets/largo-recent-posts.rst
	doxphp < ../inc/widgets/largo-related-posts.php | doxphp2sphinx > api/inc/widgets/largo-related-posts.rst
	doxphp < ../inc/widgets/largo-series-posts.php | doxphp2sphinx > api/inc/widgets/largo-series-posts.rst
	doxphp < ../inc/widgets/largo-sidebar-featured.php | doxphp2sphinx > api/inc/widgets/largo-sidebar-featured.rst
	doxphp < ../inc/widgets/largo-staff.php | doxphp2sphinx > api/inc/widgets/largo-staff.rst
	doxphp < ../inc/widgets/largo-tag-list.php | doxphp2sphinx > api/inc/widgets/largo-tag-list.rst
	doxphp < ../inc/widgets/largo-taxonomy-list.php | doxphp2sphinx > api/inc/widgets/largo-taxonomy-list.rst
	doxphp < ../inc/widgets/largo-twitter.php | doxphp2sphinx > api/inc/widgets/largo-twitter.rst
	doxphp < ../inc/widgets.php | doxphp2sphinx > api/inc/widgets.rst
	doxphp < ../inc/wp-taxonomy-landing/functions/cftl-admin.php | doxphp2sphinx > api/inc/wp-taxonomy-landing/functions/cftl-admin.rst
	doxphp < ../inc/wp-taxonomy-landing/functions/cftl-intercept-queries.php | doxphp2sphinx > api/inc/wp-taxonomy-landing/functions/cftl-intercept-queries.rst
	doxphp < ../inc/wp-taxonomy-landing/functions/cftl-series-order.php | doxphp2sphinx > api/inc/wp-taxonomy-landing/functions/cftl-series-order.rst
	doxphp < ../inc/wp-taxonomy-landing/taxonomy-landing.php | doxphp2sphinx > api/inc/wp-taxonomy-landing/taxonomy-landing.rst
	doxphp < ../index.php | doxphp2sphinx > api/index.rst
	doxphp < ../largo-apis.php | doxphp2sphinx > api/largo-apis.rst
	doxphp < ../options.php | doxphp2sphinx > api/options.rst
	doxphp < ../page.php | doxphp2sphinx > api/page.rst
	doxphp < ../partials/author-bio-description.php | doxphp2sphinx > api/partials/author-bio-description.rst
	doxphp < ../partials/author-bio-social-links.php | doxphp2sphinx > api/partials/author-bio-social-links.rst
	doxphp < ../partials/content-argolinks.php | doxphp2sphinx > api/partials/content-argolinks.rst
	doxphp < ../partials/content-not-found.php | doxphp2sphinx > api/partials/content-not-found.rst
	doxphp < ../partials/content-page.php | doxphp2sphinx > api/partials/content-page.rst
	doxphp < ../partials/content-series.php | doxphp2sphinx > api/partials/content-series.rst
	doxphp < ../partials/content-single-classic.php | doxphp2sphinx > api/partials/content-single-classic.rst
	doxphp < ../partials/content-single.php | doxphp2sphinx > api/partials/content-single.rst
	doxphp < ../partials/content-tiny.php | doxphp2sphinx > api/partials/content-tiny.rst
	doxphp < ../partials/content.php | doxphp2sphinx > api/partials/content.rst
	doxphp < ../partials/footer-before-footer-widget-area.php | doxphp2sphinx > api/partials/footer-before-footer-widget-area.rst
	doxphp < ../partials/footer-boilerplate.php | doxphp2sphinx > api/partials/footer-boilerplate.rst
	doxphp < ../partials/footer-sticky.php | doxphp2sphinx > api/partials/footer-sticky.rst
	doxphp < ../partials/footer-widget-area.php | doxphp2sphinx > api/partials/footer-widget-area.rst
	doxphp < ../partials/header-ad-zone.php | doxphp2sphinx > api/partials/header-ad-zone.rst
	doxphp < ../partials/home-bottom-widget-area.php | doxphp2sphinx > api/partials/home-bottom-widget-area.rst
	doxphp < ../partials/home-post-list.php | doxphp2sphinx > api/partials/home-post-list.rst
	doxphp < ../partials/home-topstories.php | doxphp2sphinx > api/partials/home-topstories.rst
	doxphp < ../partials/homepage-alert.php | doxphp2sphinx > api/partials/homepage-alert.rst
	doxphp < ../partials/largo-header.php | doxphp2sphinx > api/partials/largo-header.rst
	doxphp < ../partials/nav-global.php | doxphp2sphinx > api/partials/nav-global.rst
	doxphp < ../partials/nav-main.php | doxphp2sphinx > api/partials/nav-main.rst
	doxphp < ../partials/nav-secondary.php | doxphp2sphinx > api/partials/nav-secondary.rst
	doxphp < ../partials/nav-sticky.php | doxphp2sphinx > api/partials/nav-sticky.rst
	doxphp < ../partials/sidebar-archive.php | doxphp2sphinx > api/partials/sidebar-archive.rst
	doxphp < ../partials/sidebar-fallback.php | doxphp2sphinx > api/partials/sidebar-fallback.rst
	doxphp < ../partials/sidebar-single.php | doxphp2sphinx > api/partials/sidebar-single.rst
	doxphp < ../partials/sidebar.php | doxphp2sphinx > api/partials/sidebar.rst
	doxphp < ../partials/single-hero.php | doxphp2sphinx > api/partials/single-hero.rst
	doxphp < ../partials/sticky-posts.php | doxphp2sphinx > api/partials/sticky-posts.rst
	doxphp < ../search.php | doxphp2sphinx > api/search.rst
	doxphp < ../searchform.php | doxphp2sphinx > api/searchform.rst
	doxphp < ../series-landing.php | doxphp2sphinx > api/series-landing.rst
	doxphp < ../sidebar.php | doxphp2sphinx > api/sidebar.rst
	doxphp < ../single-one-column.php | doxphp2sphinx > api/single-one-column.rst
	doxphp < ../single-two-column.php | doxphp2sphinx > api/single-two-column.rst
	doxphp < ../single.php | doxphp2sphinx > api/single.rst
	doxphp < ../tests/bootstrap.php | doxphp2sphinx > api/tests/bootstrap.rst
	doxphp < ../tests/homepages/test-homepage-class.php | doxphp2sphinx > api/tests/homepages/test-homepage-class.rst
	doxphp < ../tests/homepages/test-homepage.php | doxphp2sphinx > api/tests/homepages/test-homepage.rst
	doxphp < ../tests/inc/test-ajax-functions.php | doxphp2sphinx > api/tests/inc/test-ajax-functions.rst
	doxphp < ../tests/inc/test-avatars.php | doxphp2sphinx > api/tests/inc/test-avatars.rst
	doxphp < ../tests/inc/test-enqueue.php | doxphp2sphinx > api/tests/inc/test-enqueue.rst
	doxphp < ../tests/inc/test-featured-content.php | doxphp2sphinx > api/tests/inc/test-featured-content.rst
	doxphp < ../tests/inc/test-featured-media.php | doxphp2sphinx > api/tests/inc/test-featured-media.rst
	doxphp < ../tests/inc/test-helpers.php | doxphp2sphinx > api/tests/inc/test-helpers.rst
	doxphp < ../tests/inc/test-post-tags.php | doxphp2sphinx > api/tests/inc/test-post-tags.rst
	doxphp < ../tests/inc/test-post-templates.php | doxphp2sphinx > api/tests/inc/test-post-templates.rst
	doxphp < ../tests/inc/test-taxonomies.php | doxphp2sphinx > api/tests/inc/test-taxonomies.rst
	doxphp < ../tests/inc/test-update.php | doxphp2sphinx > api/tests/inc/test-update.rst
	doxphp < ../tests/inc/test-users.php | doxphp2sphinx > api/tests/inc/test-users.rst
	doxphp < ../tests/inc/widgets/test-disclaimer-widget.php | doxphp2sphinx > api/tests/inc/widgets/test-disclaimer-widget.rst
	doxphp < ../tests/inc/widgets/test-largo-post-series-links.php | doxphp2sphinx > api/tests/inc/widgets/test-largo-post-series-links.rst
	doxphp < ../tests/inc/widgets/test-largo-series-posts.php | doxphp2sphinx > api/tests/inc/widgets/test-largo-series-posts.rst
	doxphp < ../tests/mock/mock-admin-functions.php | doxphp2sphinx > api/tests/mock/mock-admin-functions.rst
	doxphp < ../tests/mock/mock-options-framework.php | doxphp2sphinx > api/tests/mock/mock-options-framework.rst
	doxphp < ../tests/mock/test-mock-admin-functions.php | doxphp2sphinx > api/tests/mock/test-mock-admin-functions.rst
	doxphp < ../tests/templates/test-homepage.php | doxphp2sphinx > api/tests/templates/test-homepage.rst

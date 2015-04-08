.. php:class:: Largo_Term_Icons

      Display the fields for selecting icons for terms in the "post-type" taxonomy

   .. php:method:: Largo_Term_Icons::__construct()

   .. php:method:: Largo_Term_Icons::register_taxonomy()

      Register the taxonomy post-type

   .. php:method:: Largo_Term_Icons::get_icons_config()

      Retrieves the Fontello config.json information about the glyphs

   .. php:method:: Largo_Term_Icons::get_icon_taxonomies()

   .. php:method:: Largo_Term_Icons::display_fields()

      Renders the form fields on the term edit page

   .. php:method:: Largo_Term_Icons::display_add_new_field()

   .. php:method:: Largo_Term_Icons::admin_enqueue_scripts()

      Attach the Javascript and Stylesheets to the term edit page

   .. php:method:: Largo_Term_Icons::edit_terms()

      Save the results from the term edit page

   .. php:method:: Largo_Term_Icons::get_icon()

      Retrieve the icon information for a term

      :param term|string $taxonomy_or_term: - the term object of the taxonomy name
      :param int $term_id: - the term id when the first parameter is the taxonomy name

   .. php:method:: Largo_Term_Icons::the_icon()

      Output the icon for a term

   .. php:attr:: $largo
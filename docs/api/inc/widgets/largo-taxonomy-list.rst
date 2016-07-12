inc/widgets/largo-taxonomy-list.php
===================================

.. php:method:: largo_taxonomy_list_widget::__construct()

      Constructor

   .. php:method:: largo_taxonomy_list_widget::widget()

      Output the widget

      :param array $args: Sidebar-related args
      :param array $instance: Instance-specific widget arguments

      :link: https://developer.wordpress.org/reference/functions/get_terms/

      :uses: largo_taxonomy_list_widget::render_series_list

      :uses: largo_taxonomy_list_widget::render_term_list

   .. php:method:: largo_taxonomy_list_widget::update()

      Sanitize and save widget arguments

   .. php:method:: largo_taxonomy_list_widget::form()

      Render the widget form
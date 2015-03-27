.. php:class:: MockOptionsFramework

      The options framework doesn't load in context of tests,
      so we need a way to mock its API when testing Largo

   .. php:attr:: $options

   .. php:method:: MockOptionsFramework::__construct()

   .. php:method:: MockOptionsFramework::populate_defaults()

   .. php:method:: MockOptionsFramework::get_option()

   .. php:method:: MockOptionsFramework::set_option()

   .. php:method:: MockOptionsFramework::reset_options()

   .. php:attr:: $GLOBALS

.. php:function:: of_set_option()

.. php:function:: of_get_option()

.. php:function:: of_reset_options()
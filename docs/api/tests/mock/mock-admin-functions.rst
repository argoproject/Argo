.. php:class:: Mock_in_admin_WP_Screen

   .. php:method:: Mock_in_admin_WP_Screen::in_admin()

.. php:function:: mock_in_admin()

   Sets the admin to the parameter passed. Useful if your test needs to pass the is_admin() test. Uses $GLOBALS.

   :uses: $GLOBALS
   :param string $admin: '', network, user, site, false

.. php:function:: unmock_in_admin()

   Undoes mock_in_admin($admin)

   :uses: $GLOBALS
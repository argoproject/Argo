Largo custom classes
====================

A list of custom classes in Largo.

**``Bootstrap_Walker_Nav_Menu``**

``Extends Walker_Nav_Menu``. It's an enhanced menu walker that supports up to second-level dropdown menus using appropriate markup for Bootstrap. Found in ``/inc/nav-menus.php``.

**``Largo_Customizer``**

Implements the `Customizer <http://en.support.wordpress.com/customizer/>`_ for Largo, using the `Theme Customization API <https://codex.wordpress.org/Theme_Customization_API>`_. Found in ``inc/customizer/customizer.php.``

``Largo_Customizer`` loads the following custom classes:

  - ``Largo_WP_Customize_Multi_Checkbox_Control:`` Extends WP_Customize_Control to add a multi-checkbox option. Found in ``inc/customizer/class-largo-wp-customize-multi-checkbox-control.php.``
  - ``Largo_WP_Customize_Multi_Checkbox_Rich_Radio_Control``: Extends WP_Customize_Control to add support for the rich radio control used in choosing the homepage layout. Found in ``/inc/customizer/class-largo-wp-customize-rich-radio-control.php.``
  - ``Largo_WP_Customize_Textarea_Control:`` Extends WP_Customize_Control to add a textarea option. Found in ``/inc/customizer/class-largo-wp-customize-textarea-control.php.``
  
**``Largo_Related``**

Used to dig through posts to find IDs related to the current post. Found in ``/inc/related-content.php.``
**``Largo_Term_Icons``**

Displays the fields for selecting icons for terms in the "post-type" taxonomy. Found in ``/inc/term-icons.php.``

**``Largo_Term_Sidebars``**

Displays the fields for selecting icons for terms in the "post-type" taxonomy. Found in ``/inc/term-sidebars.php.``

# Homepage layouts

## Concept and goals

We need a way to easily override and reuse existing homepage templates in child themes, but also
wanted to build something extensible enough that it could be used in the future to create custom
homepage layouts on-the-fly, either purely programmatically or via some to-be-determined interface
in the WordPress dashboard.

## The basics

Largo registers several default homepage layouts. Each homepage layout is a class, similar to the
way each widget is an instance of WP_Widget.

Here's an example of a dead simple homepage layout class:

    <?php

    include_once get_template_directory() . '/homepages/homepage-class.php';

    class MyCustomLayout extends Homepage {
      function __construct($options=array()) {
        $defaults = array(
          'name' => __('My Custom Homepage Layout', 'largo'),
          'description' => __('Lorem ipsum dolor sit amet.', 'largo'),
          'template' => get_stylesheet_directory() . '/homepages/templates/my-custom-homepage-template.php'
        );
		$options = array_merge($defaults, $options);
		parent::__construct($options);
      }
    }

Every homepage should have, at minimum, a $name, $description and $template defined.

The next thing to do is register your homepage:

    function register_my_custom_homepage_layout() {
        register_homepage_layout('MyCustomLayout');
    }
    add_action('init', 'register_my_custom_homepage_layout', 0);

Once this is done, your homepage layout will show as an option in Theme Options > Layout as well as
the Customizer.

# Defining zones

Zones are areas of your homepage layout that mark where content can be placed.

You mark zones by changing your homepage layout template.

Here's an example of what the template for MyCustomLayout might look like:

    <?php

    <div class="container">
        <div class="row-fluid">
            <div class="span8">
                <?php echo $bigStory; ?>
            </div>
            <div class="span4">
                <?php echo $extraContent; ?>
            </div>
        </div>
    </div>

The way you then provide the content to be placed in your template at those markers is by defining
methods on your class that correspond to said markers. For example, for this template, we could expand
our MyCustomLayout class:

    class MyCustomLayout extends Homepage {
      var $name = 'My Custom Homepage Layout';
      var $description = 'Lorem ipsum dolor sit amet.';

      function __construct($options=array()) {
        $defaults = array(
          'template' => get_stylesheet_directory() . '/homepages/templates/my-custom-homepage-template.php'
        );
        $options = array_merge($defaults, $options);
        $this->load($options);
      }

      function bigStory() {
        return 'Hello! This is where my BIG STORY would show up if I had one.';
      }

      function extraContent() {
        return 'I can put any extra content I want to display next to the big story here. Maybe related articles?';
      }
    }

Each method is expected to return a string.

# Render the layout

To render your homepage layout, you simply:

    $homepage_layout = new MyCustomLayout();
    $homepage_layout->render();

You can also use a few helper functions to render the currently active homepage layout:

    $active_layout = largo_get_active_homepage_layout();
    largo_render_homepage_layout($active_layout);

# Directory layout

There are no hard and fast rules for directory structure when it comes to custom homepage layouts.

You can start by mirroring the structure Largo's homepages directory.

For example:

    my_child_theme/
        homepages/
            assets/
            layouts/
                MyCustomLayout.php
            templates/
                my-custom-homepage-template.php


# Removing or modifying existing layouts

If you want to remove a layout, you must unregister it. For example:

    function unregister_a_layout() {
        unregister_homepage_layout('HomepageSingle');
    }
    add_action('init', 'unregister_a_layout', 10);

This will remove the included homepage layout. This layout resides at homepages/layouts/HomepageSingle.php

To modify the HomepageSingle layout, you can unregister the default and provide your own class
that inherits from HomepageSingle. For example:

    class MyOtherCustomHomepageLayout extends HomepageSingle {
        $name = "Homepage layout based on Largo's 'HomepageSingle' layout";
        $description = "Modified version of the default layout with a different big story zone.";

        function bigStory() {
            return "We transformed the big story into something else! Err, I mean we got rid of it!";
        }
    }

    function replace_a_default_homepage_layout() {
        unregister_homepage_layout('HomepageSingle');
        register_homepage_layout('MyOtherCustomHomepageLayout');
    }
    add_action('init', 'replace_a_default_homepage_layout', 10);

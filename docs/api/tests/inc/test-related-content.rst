.. php:class:: RelatedContentTestFunctions

   .. php:method:: RelatedContentTestFunctions::setUp()

   .. php:method:: RelatedContentTestFunctions::test_largo_get_related_topics_for_category()

   .. php:method:: RelatedContentTestFunctions::test__tags_associated_with_category()

   .. php:method:: RelatedContentTestFunctions::test__subcategories_for_category()

   .. php:method:: RelatedContentTestFunctions::test_largo_get_post_related_topics()

   .. php:method:: RelatedContentTestFunctions::test_largo_get_recent_posts_for_term()

   .. php:method:: RelatedContentTestFunctions::test_largo_has_categories_or_tags()

   .. php:method:: RelatedContentTestFunctions::test_largo_categories_and_tags()

   .. php:method:: RelatedContentTestFunctions::test_largo_top_term()

   .. php:method:: RelatedContentTestFunctions::test_largo_filter_get_post_related_topics()

   .. php:method:: RelatedContentTestFunctions::test_largo_filter_get_recent_posts_for_term_query_args()

.. php:class:: LargoRelatedTestFunctions

   .. php:method:: LargoRelatedTestFunctions::setUp()

   .. php:method:: LargoRelatedTestFunctions::test___construct()

   .. php:method:: LargoRelatedTestFunctions::test_popularity_sort()

   .. php:method:: LargoRelatedTestFunctions::test_unorganized_series()

      Test the function with a lot of different conditions

      - Series without organization
      - Series with CFTL post with organization information
      	- ASC
      	- series_custom
      	- DESC
      	- featured, DESC
      	- featured, ASC
      - No series, but category
      - No series, but tag
      - Tags and Categories
      - No series or category or tag

   .. php:method:: LargoRelatedTestFunctions::test_series_asc()

   .. php:method:: LargoRelatedTestFunctions::test_series_series_custom()

   .. php:method:: LargoRelatedTestFunctions::test_series_desc()

   .. php:method:: LargoRelatedTestFunctions::test_series_featured_desc()

   .. php:method:: LargoRelatedTestFunctions::test_series_featured_asc()

   .. php:method:: LargoRelatedTestFunctions::test_category()

   .. php:method:: LargoRelatedTestFunctions::test_tags()

   .. php:method:: LargoRelatedTestFunctions::test_category_and_tag()

   .. php:method:: LargoRelatedTestFunctions::test_recent_posts()
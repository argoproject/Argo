inc/byline_class.php
====================

.. php:method:: Largo_Byline::populate_variables()

      Set us up the vars

          - 'post_id': an integer post ID
          - 'exclude_date': boolean whether or not to include the date in the byline

      :param array $args: Associative array containing following keys:

      :see: $post_id $ets this from $args

      :see: $exclude_date $ets this from $args

      :see: $custom $ills this array with the output of get_post_custom

      :see: $author_id $ets this from the post meta

   .. php:method:: Largo_Byline::generate_byline()

      this creates the byline text and adds it to $this->output

      :see: $output $reates this

   .. php:method:: Largo_Byline::__toString()

      This is what turns the whole class into a string

      :see: $output

      :see: generate_byline()

   .. php:method:: Largo_Byline::avatar()

      On single posts, output the avatar for the author object
      This supports both Largo_Byline and Largo_CoAuthors_Byline

   .. php:method:: Largo_Byline::author_link()

      a wrapper around largo_author_link

   .. php:method:: Largo_Byline::job_title()

      If job titles are enabled by Largo's theme option, display the one for this author

   .. php:method:: Largo_Byline::twitter()

      If this author has a twitter ID, output it as a link on an i.icon-twitter

   .. php:method:: Largo_Byline::maybe_published_date()

      Determine whether to display the date

   .. php:method:: Largo_Byline::published_date()

      A wrapper around largo_time to determine when the post was published

   .. php:method:: Largo_Byline::edit_link()

      Output the edit link for this post, only to admin users

   .. php:method:: Largo_Custom_Byline::generate_byline()

      differs from Largo_Byline in following ways:
      - no avatar
      - no job title
      - no twitter

.. php:class:: Largo_CoAuthors_Byline

      Bylines for Co-Authors Plus guest authors

   .. php:attr:: $author

      Temporary variable used to contain the coauthor being rendered by the loop inside generate_byline();

      :see: $this->generate_byline();

   .. php:method:: Largo_CoAuthors_Byline::generate_byline()

      Differs from Largo_Byline in following ways:

      - gets list of coauthors, runs avatar, author_link, job_title, organization, twitter for each of those
      - joins list of coauthors with commas and 'and' as appropriate

   .. php:method:: Largo_CoAuthors_Byline::author_link()

      A coauthors-specific byline link method

   .. php:method:: Largo_CoAuthors_Byline::job_title()

      Job title from the coauthors object

   .. php:method:: Largo_CoAuthors_Byline::organization()

      Output coauthor users's organization

   .. php:method:: Largo_CoAuthors_Byline::twitter()

      twitter link from the coauthors object
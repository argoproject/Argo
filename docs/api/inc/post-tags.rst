inc/post-tags.php
=================

.. php:function:: largo_time_diff()

   Given a time, if it was less than 24 hours ago return how many hours ago that was, otherwise return the 'F j, Y' formatted date

   :param int $modified: the Unix timestamp for the modified date

   :returns: string $TML for the either "x hours ago" or the submitted date, formatted

   :since: 0.5.5

   :see: https://secure.php.net/manual/en/function.date.php

   :see: https://github.com/INN/Largo/pull/1265

.. php:function:: largo_trim_sentences()

   Attempt to trim input at sentence breaks

   :param $input $tring:
   :param $sentences $umber: of sentences to trim to
   :param $echo $cho: the string or return it (default: return)

   :returns: $output $rimmed string

   :since: 0.3

.. php:function:: largo_maybe_top_term()

   If largo_top_term() would output a term, wrap that in an h5.top-term and output it to the page.

   Takes the same argument array as largo_top_term(), and passes that argument array to
   largo_top_term() with 'echo' => False. largo_maybe_top_term() handles the echo decision.

   :since: 0.5.5

   :uses: largo_top_term
   :param Array $args: the same argument array that would be passed to largo_top_term()

.. php:function:: largo_edited_date()

   Display the last-edited date for this post

   :since: 0.5.5

   :link: https://github.com/INN/Largo/issues/1341

.. php:function:: largo_after_hero_largo_edited_date()

   Output largo_edited_date() on the single post template

   :since: 0.5.5

   :action: largo_after_hero

   :uses: largo_edited_date

   :link: https://github.com/INN/Largo/issues/1341
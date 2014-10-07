/**
 * Handles changing default sidebar option based on which post/page layout option is selected
 */
(function($) {
    $(document).ready(function() {
        var post_template = $('#post_template');
        var custom_sidebar = $('#custom_sidebar');
        var none_option = $(custom_sidebar.find('[value="none"]'));
        var default_text = none_option.text();

        post_template.on('change', function() {
            custom_sidebar.find('option').removeAttr('selected');

            if (post_template.val() == '') {
                if ($(post_template.find('option').get(0)).text().match(/Two Column/g))
                    none_option.text(default_sidebar_labels['single-two-column.php']);

                if ($(post_template.find('option').get(0)).text().match(/One Column/g))
                    none_option.text(default_sidebar_labels['single-one-column.php']);

                custom_sidebar.removeAttr('disabled');
            }

            if (default_sidebar_labels[post_template.val()]) {
                none_option.text(default_sidebar_labels[post_template.val()]);
                custom_sidebar.removeAttr('disabled');
            }

            if (post_template.val() == 'full-page.php') {
                custom_sidebar.find('option').removeAttr('selected');
                none_option.attr('selected', 'selected');
                none_option.text(default_sidebar_labels[post_template.val()]);
                custom_sidebar.attr('disabled', 'disabled');
            }

            none_option.attr('selected', 'selected');
        });
    });
})(jQuery);

(function() {
    var $ = jQuery;

    $(document).ready(function() {
        var avatar_input = $('#largo-avatar-input'),
            avatar_remove = $('#largo-remove-avatar'),
            avatar_display = $('#largo-avatar-display'),
            ajax_opts = {
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'largo_remove_avatar'
                },
                dataType: 'json'
            };

        avatar_remove.click(function() {
            ajax_opts.success = function(data) {
                if (data.success) {
                    avatar_input.show();
                    avatar_display.empty();
                }
            }
            $.ajax(ajax_opts);
            return false;
        });

        avatar_input.find('input').change(function() {
            avatar_display.empty();
            avatar_display.html('<p>Click "Update Profile" to save your avatar.</p>');
        });
    });
}());

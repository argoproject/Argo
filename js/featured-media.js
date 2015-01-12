var LFM = _.extend(LFM || {}, {
    Utils: {},
    Views: {},
    instances: {},
});

(function() {
    var $ = jQuery;

    var featuredMediaIdToView = {
        'embed-code': 'featuredEmbedCodeView',
        //'video': 'featuredVideoView',
        //'photo-gallery': 'featuredPhotoGalleryView',
        //'image': 'featuredImageView'
    };

    /* Models */
    var featuredMediaModel = Backbone.Model.extend({
        url: window.ajaxurl,

        sync: function(method, model, options) {
            var data;

            if (method == 'create' || method == 'update')
                data =  model.toJSON();
            else
                data = {};

            data = _.extend(data, { post_id: LFM.Utils.getPostId() });

            var url = this.url;
            var success = options.success;
            var error = options.error;
            LFM.Utils.doAjax(url, data, success, error);
        }
    });

    /* Collections */
    var featuredMediaCollection = Backbone.Collection.extend();

    /* Views for the modal and subviews for frames */
    var featuredMediaModal = wp.media.view.Modal.extend();

    var featuredMediaFrame = wp.Backbone.View.extend({
        events: {
            'click a.media-menu-item': 'setActive'
        },

        template: wp.media.template('featured-media-frame'),

        setActive: function(id_or_event) {
            var id,
                selector;

            if (typeof id_or_event.type !== 'undefined') {
                id = $(id_or_event.currentTarget).attr('id');
                selector = 'a#' + id;
            } else {
                id = id_or_event;
                selector = 'a#media-type-' + id;
            }

            var optionLink = this.$el.find(selector);
            optionLink.siblings().removeClass('active');
            optionLink.addClass('active');

            id = id.replace('media-type-', '');
            if (typeof LFM.instances[id] == 'undefined') {
                view = featuredMediaIdToView[id];
                LFM.instances[id] = new LFM.Views[view]({
                    option: _.findWhere(LFM.options, { id: id })
                });
            }
            LFM.instances.frame.views.set('.media-frame-content', LFM.instances[id]);
        }
    });

    var featuredMediaOptions = wp.Backbone.View.extend({
        template: wp.media.template('featured-media-options'),
    });

    /* Views for media types */
    var featuredMediaBaseView = wp.Backbone.View.extend({
        id: function() {
            return 'media-editor-' + this.options.option.id;
        }
    });

    var featuredEmbedCodeView;
    LFM.Views.featuredEmbedCodeView = featuredEmbedCodeView = featuredMediaBaseView.extend({
        template: wp.media.template('featured-embed-code')
    });

    var featuredPhotoGalleryView;
    LFM.Views.featuredPhotoGalleryView = featuredPhotoGalleryView = featuredMediaBaseView.extend({
        template: wp.media.template('featured-photo-gallery')
    });

    /* View for save button */
    var featuredSaveButtonView;
    LFM.Views.featuredSaveButtonView = featuredSaveButtonView = wp.Backbone.View.extend({
        className: 'media-toolbar',

        events: {
            'click a.button': 'save'
        },

        template: wp.media.template('featured-media-save'),

        save: function() {
            var currentView = LFM.instances.frame.views.get('.media-frame-content');

            if (currentView.length > 0)
                currentView = currentView[0];
            else
                return false;

            if (typeof this.model == 'undefined')
                this.model = new featuredMediaModel();

            var attrs = LFM.Utils.formArrayToObj(currentView.$el.find('form').serializeArray());
            this.model.save(attrs, { success: LFM.Utils.closeModal });
        }
    });

    /* Utils */
    var formArrayToObj = function(arr) {
        var ret = {};
        _.each(arr, function(item) {
            ret[item.name] = item.value;
        });
        return ret;
    };
    LFM.Utils.formArrayToObj = formArrayToObj;

    var doAjax = function(url, data, success, error) {
        var json = JSON.stringify(data);

        var action;
        if (_.keys(data).length == 1)
            action = 'largo_featured_media_read';
        else
            action = 'largo_featured_media_save';

        params = {
            url: ajaxurl,
            type: 'POST',
            data: {
                action: action,
                path: url,
                data: json
            },
            dataType: 'json',
            success: function(data, textStatus, jqXHR) {
                if (success)
                    success(data, textStatus, jqXHR);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (error)
                    error(jqXHR, textStatus, errorThrown);
            }
        }

        $.ajax(params);
    };
    LFM.Utils.doAjax = doAjax;

    var getPostId = function() {
        return $( '#post_ID' ).val();
    }
    LFM.Utils.getPostId = getPostId;

    var closeModal = function() {
        LFM.instances.modal.close();
    };
    LFM.Utils.closeModal = closeModal;

    $(document).ready(function() {
        $('#set-featured-media-button').click(function() {
            var initialViewId = 'embed-code';

            if (typeof LFM.instances.modal == 'undefined') {
                LFM.instances.modal = new featuredMediaModal({ propagate: false });

                var frame;
                LFM.instances.frame = frame = new featuredMediaFrame();
                LFM.instances.modal.views.set('.media-modal-content', frame);

                var options;
                LFM.instances.options = options = new featuredMediaOptions({ mediaTypes: LFM.options });
                frame.views.set('.media-frame-menu', options);

                var initialView,
                    option = _.findWhere(LFM.options, { id: initialViewId });

                var model = new featuredMediaModel();
                model.fetch({
                    success: function(data) {
                        LFM.instances[initialViewId] = initialView = new featuredEmbedCodeView({
                            option: option,
                            model: data
                        });
                        frame.views.set('.media-frame-content', initialView);

                        var saveButtonView;
                        LFM.instances.saveButtonView = saveButtonView = new featuredSaveButtonView({ model: model });
                        frame.views.set('.media-frame-toolbar', saveButtonView);

                        LFM.instances.modal.open();
                        LFM.instances.frame.setActive(initialViewId);
                    }
                });
            } else {
                LFM.instances.modal.open();
                LFM.instances.frame.setActive(initialViewId);
            }
            return false;
        });
    })

}());

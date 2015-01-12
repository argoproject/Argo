var featuredMedia = {
    Views: {},
    instances: {},
};

(function() {
    var $ = jQuery;

    var featuredMediaIdToView = {
        'embed-code': 'featuredEmbedCodeView',
        'video': 'featuredVideoView',
        'photo-gallery': 'featuredPhotoGalleryView',
        'image': 'featuredImageView'
    };

    /* Models */
    var featuredMediaModel = Backbone.Model.extend({});

    /* Collections */
    var featuredMediaCollection = Backbone.Collection.extend({});

    /* Views for the modal and subviews for frames */
    var featuredMediaModal = wp.media.view.Modal.extend();

    var featuredMediaFrame = wp.Backbone.View.extend({
        events: {
            'click a': 'setActive'
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

            if (typeof featuredMedia.instances[id] == 'undefined') {
                id = id.replace('media-type-', '');
                view = featuredMediaIdToView[id];
                featuredMedia.instances[id] = new featuredMedia.Views[view]({
                    model: featuredMedia.options.findWhere({ id: id })
                });
                featuredMedia.instances.frame.views.set('.media-frame-content', featuredMedia.instances[id]);
            }
        }
    });

    var featuredMediaOptions = wp.Backbone.View.extend({
        template: wp.media.template('featured-media-options'),
    });

    /* Views for media types */
    var featuredMediaBaseView = wp.Backbone.View.extend({
        id: function() {
            return 'media-editor' + this.model.get('id');
        }
    });

    var featuredEmbedCodeView;
    featuredMedia.Views.featuredEmbedCodeView = featuredEmbedCodeView = featuredMediaBaseView.extend({
        template: wp.media.template('featured-embed-code')
    });

    var featuredPhotoGalleryView;
    featuredMedia.Views.featuredPhotoGalleryView = featuredPhotoGalleryView = featuredMediaBaseView.extend({
        template: wp.media.template('featured-photo-gallery')
    });

    $(document).ready(function() {
        var instances;
        featuredMedia.instances = instances = {};

        var options;
        featuredMedia.options = options = new featuredMediaCollection(LFM);

        $('#set-featured-media-button').click(function() {
            if (typeof instances.modal == 'undefined') {
                var mediaTypes;
                featuredMedia.mediaTypes = mediaTypes = new featuredMediaCollection(LFM);

                instances.modal = new featuredMediaModal({ propagate: false });

                var frame;
                instances.frame = frame = new featuredMediaFrame();
                instances.modal.views.set('.media-modal-content', frame);

                var options;
                instances.options = options = new featuredMediaOptions({ mediaTypes: mediaTypes });
                frame.views.set('.media-frame-menu', options);

                var initialViewId = 'embed-code';
                var initialView;
                featuredMedia.instances[initialViewId] = initialView = new featuredEmbedCodeView({
                    model: mediaTypes.findWhere({ id: initialViewId })
                });
                frame.views.set('.media-frame-content', initialView);

            }

            instances.modal.open();
            instances.frame.setActive(initialViewId);
            return false;
        });
    })

}());
